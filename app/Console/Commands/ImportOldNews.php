<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Media;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DOMDocument;
use DOMXPath;

class ImportOldNews extends Command
{
    protected $signature = 'import:old-news {--fresh : Delete existing news before importing}';
    protected $description = 'Import news from old Magic Group website with full content';

    private $baseUrl = 'https://www.magicgroup.mn';
    private $totalPages = 5;

    public function handle()
    {
        $this->info('Starting import of old news...');

        if ($this->option('fresh')) {
            $this->info('Deleting existing news posts...');
            Post::whereHas('category', function ($q) {
                $q->where('slug', 'news');
            })->delete();
        }

        // Get or create "News" category
        $category = Category::firstOrCreate(
            ['slug' => 'news'],
            ['name' => 'News', 'slug' => 'news', 'status' => 'active']
        );

        $category->setTranslation('name', 'mn', 'Мэдээ');
        $category->setTranslation('name', 'en', 'News');
        $category->setTranslation('name', 'zh', '新闻');

        $author = User::first();
        if (!$author) {
            $this->error('No users found. Please create a user first.');
            return 1;
        }

        // Scrape all news
        $allNewsItems = $this->scrapeAllNewsPages();

        $imported = 0;
        $skipped = 0;

        foreach ($allNewsItems as $item) {
            try {
                $this->info("Importing: {$item['title']}");

                $slug = Str::slug($item['title']);

                if (Post::where('slug', $slug)->exists()) {
                    $this->warn("  Skipped: Already exists");
                    $skipped++;
                    continue;
                }

                // Download image
                $featuredImageId = null;
                if (!empty($item['image'])) {
                    $featuredImageId = $this->downloadImage($item['image']);
                }

                // Create post
                $post = Post::create([
                    'title' => $item['title'],
                    'slug' => $slug,
                    'excerpt' => $item['excerpt'] ?? Str::limit(strip_tags($item['content'] ?? ''), 150),
                    'content' => $item['content'] ?? '<p>' . $item['title'] . '</p>',
                    'status' => 'published',
                    'published_at' => $item['date'],
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'featured_image_id' => $featuredImageId,
                    'is_featured' => false,
                ]);

                $post->setTranslation('title', 'mn', $item['title']);
                $post->setTranslation('excerpt', 'mn', $item['excerpt'] ?? Str::limit(strip_tags($item['content'] ?? ''), 150));
                $post->setTranslation('content', 'mn', $item['content'] ?? '<p>' . $item['title'] . '</p>');

                $this->info("  ✓ Imported successfully");
                $imported++;

            } catch (\Exception $e) {
                $this->error("  Error: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("Import completed!");
        $this->info("Imported: {$imported}");
        $this->info("Skipped: {$skipped}");
        $this->info("Total: " . ($imported + $skipped));

        return 0;
    }

    private function scrapeAllNewsPages()
    {
        $this->info("Scraping news from {$this->totalPages} pages...");
        $allNews = [];

        for ($page = 1; $page <= $this->totalPages; $page++) {
            $this->info("Fetching page {$page}...");

            try {
                $url = $page === 1
                    ? "{$this->baseUrl}/mn/magic-group/news.html"
                    : "{$this->baseUrl}/mn/magic-group/news.html?page={$page}";

                $response = Http::timeout(30)->get($url);

                if (!$response->successful()) {
                    $this->warn("Failed to fetch page {$page}");
                    continue;
                }

                $html = $response->body();
                $newsItems = $this->parseNewsListPage($html);

                // Fetch details for each news item
                foreach ($newsItems as $newsItem) {
                    $this->info("  Fetching details for: {$newsItem['title']}");
                    $details = $this->fetchNewsDetails($newsItem['url']);
                    if ($details) {
                        $newsItem['content'] = $details['content'];
                        $newsItem['excerpt'] = $details['excerpt'];
                    }
                    $allNews[] = $newsItem;

                    // Small delay
                    usleep(300000); // 0.3 seconds
                }

            } catch (\Exception $e) {
                $this->error("Error scraping page {$page}: {$e->getMessage()}");
            }
        }

        $this->info("Total news items found: " . count($allNews));
        return $allNews;
    }

    private function parseNewsListPage($html)
    {
        $newsItems = [];

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($dom);

        // Find all news items (adjust selector based on actual HTML structure)
        $nodes = $xpath->query("//div[contains(@class, 'news-item')] | //article | //div[contains(@class, 'item')]");

        foreach ($nodes as $node) {
            try {
                // Extract title
                $titleNode = $xpath->query(".//h2 | .//h3 | .//a[contains(@href, '/news/')]", $node)->item(0);
                if (!$titleNode) continue;

                $title = trim($titleNode->textContent);

                // Extract link
                $linkNode = $xpath->query(".//a[contains(@href, '/news/')]", $node)->item(0);
                if (!$linkNode) continue;

                $url = $linkNode->getAttribute('href');
                if (!str_starts_with($url, 'http')) {
                    $url = $this->baseUrl . $url;
                }

                // Extract date
                $dateNode = $xpath->query(".//*[contains(@class, 'date')]", $node)->item(0);
                $date = $dateNode ? trim($dateNode->textContent) : date('Y-m-d');

                // Extract image
                $imgNode = $xpath->query(".//img", $node)->item(0);
                $image = null;
                if ($imgNode) {
                    $src = $imgNode->getAttribute('src');
                    if ($src && !str_starts_with($src, 'http')) {
                        $image = $src;
                    }
                }

                $newsItems[] = [
                    'title' => $title,
                    'url' => $url,
                    'date' => $this->parseDate($date),
                    'image' => $image,
                ];

            } catch (\Exception $e) {
                continue;
            }
        }

        return $newsItems;
    }

    private function fetchNewsDetails($url)
    {
        try {
            $response = Http::timeout(30)->get($url);

            if (!$response->successful()) {
                return null;
            }

            $html = $response->body();

            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
            $xpath = new DOMXPath($dom);

            // Find content area (adjust selector based on actual HTML)
            $contentNode = $xpath->query("//div[contains(@class, 'content')] | //article | //div[contains(@class, 'news-content')]")->item(0);

            if (!$contentNode) {
                return null;
            }

            $content = $dom->saveHTML($contentNode);
            $excerpt = Str::limit(strip_tags($content), 200);

            return [
                'content' => $content,
                'excerpt' => $excerpt,
            ];

        } catch (\Exception $e) {
            $this->warn("  Failed to fetch details: {$e->getMessage()}");
            return null;
        }
    }

    private function parseDate($dateString)
    {
        // Try to parse various date formats
        $dateString = trim($dateString);

        // Check if already in Y-m-d format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateString)) {
            return $dateString;
        }

        // Try other common formats
        try {
            $date = new \DateTime($dateString);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            return date('Y-m-d');
        }
    }

    private function downloadImage($imageUrl)
    {
        try {
            $fullUrl = str_starts_with($imageUrl, 'http')
                ? $imageUrl
                : $this->baseUrl . $imageUrl;

            $this->info("  Downloading image: {$fullUrl}");

            $response = Http::timeout(30)->get($fullUrl);

            if (!$response->successful()) {
                return null;
            }

            $extension = pathinfo($imageUrl, PATHINFO_EXTENSION) ?: 'jpg';
            $fileName = time() . '_' . Str::random(10) . '.' . $extension;
            $path = 'uploads/' . $fileName;

            Storage::disk('public')->put($path, $response->body());

            $media = Media::create([
                'name' => pathinfo($imageUrl, PATHINFO_FILENAME),
                'file_name' => $fileName,
                'mime_type' => $response->header('Content-Type') ?? 'image/jpeg',
                'path' => $path,
                'size' => strlen($response->body()),
                'disk' => 'public',
                'metadata' => [
                    'original_url' => $fullUrl,
                    'extension' => $extension,
                ],
                'uploaded_by' => User::first()->id,
            ]);

            $this->info("  ✓ Image downloaded");
            return $media->id;

        } catch (\Exception $e) {
            $this->warn("  Failed to download image: {$e->getMessage()}");
            return null;
        }
    }
}
