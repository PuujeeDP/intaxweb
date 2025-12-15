<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportMsnewsJson extends Command
{
    protected $signature = 'import:msnews';
    protected $description = 'Import msnews.json from storage/app to posts table';

    public function handle()
    {
        $path = storage_path('app/msnews.json');
        if (!File::exists($path)) {
            $this->error('File not found: ' . $path);
            return 1;
        }

        $json = File::get($path);
        $items = json_decode($json, true);

        if (!is_array($items)) {
            $this->error('Invalid JSON structure.');
            return 1;
        }

        $usedSlugs = [];

        function generateSlug($name, &$usedSlugs)
        {
            // Зайг "-" болгоно, жижиг үсэг болгоно
            $slug = strtolower(trim(preg_replace('/\s+/', '-', $name)));
            $baseSlug = $slug;
            $i = 1;
            // Давхардсан эсэхийг шалгана
            while (in_array($slug, $usedSlugs)) {
                $slug = $baseSlug . '-' . $i;
                $i++;
            }
            $usedSlugs[] = $slug;
            return $slug;
        }

        function fixDate($date)
        {
            // Хоосон, null, эсвэл 0000-00-00 00:00:00 бол null болгоно
            if (empty($date) || $date == '0000-00-00 00:00:00') {
                return null;
            }
            return $date;
        }

        function limit255($str)
        {
            return mb_substr($str, 0, 255);
        }




        foreach ($items as $item) {

            if (strpos($item['himage'], 'posts') !== false ) {
                $category_id = 3;
            } elseif (strpos($item['himage'], 'podcast') !== false ) {
                $category_id = 4;
            } elseif (strpos($item['himage'], 'events') !== false) {
                $category_id = 2;
            } else {
                $category_id = 1;
            }
            $slug = limit255(generateSlug($item['name'] ?? '', $usedSlugs));

            DB::table('posts')->insert([
                'id' => $item['id'] ?? null,
                'title' => limit255($item['name']) ?? null,
                'slug' => $slug,
                'excerpt' => $item['news_desc'] ?? null,
                'content' => $item['news'] ?? null,
                'category_id' => $category_id ?? null,
                'author_id' => 1,
                'featured_image_id' => null,
                'status' => 'published',
                'published_at' => fixDate($item['newsdate'] ?? null) ?? now(),
                'meta_tags' => null,
                'meta_title' => limit255($item['name']) ?? null,
                'meta_description' => $item['name'] ?? null,
                'views' => 0,
                'created_at' => fixDate($item['created_at'] ?? null) ?? now(),
                'updated_at' => fixDate($item['updated_at'] ?? null) ?? now(),
                'deleted_at' => fixDate($item['deleted_at'] ?? null),
            ]);
        }

        $this->info('Import finished!');
        return 0;
    }
}
