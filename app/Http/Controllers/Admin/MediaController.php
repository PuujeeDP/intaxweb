<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $query = Media::with(['uploader'])
            ->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('file_name', 'like', '%' . $request->search . '%');
        }

        if ($request->type) {
            $query->where('mime_type', 'like', $request->type . '%');
        }

        $media = $query->paginate(24)->withQueryString();

        return Inertia::render('Admin/Media/Index', [
            'media' => $media,
            'filters' => $request->only(['search', 'type']),
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx|max:5120', // 5MB max
            ]);

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . str_replace(' ', '_', $originalName);

            // Store file
            $path = $file->storeAs('uploads', $fileName, 'public');

            // Create media record
            $media = Media::create([
                'name' => pathinfo($originalName, PATHINFO_FILENAME),
                'file_name' => $fileName,
                'mime_type' => $file->getMimeType(),
                'path' => $path,
                'size' => $file->getSize(),
                'disk' => 'public',
                'metadata' => [
                    'original_name' => $originalName,
                    'extension' => $extension,
                ],
                'uploaded_by' => Auth::check() ? Auth::id() : null,
            ]);

            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded successfully',
                    'media' => $media,
                ]);
            }

            return back()->with('success', 'File uploaded successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                    'error' => $e->getMessage(),
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload failed',
                    'error' => $e->getMessage(),
                ], 500);
            }
            return back()->with('error', 'Failed to upload file: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Media $media)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $media->update($validated);

        return back()->with('success', 'Media updated successfully');
    }

    public function destroy(Media $media)
    {
        // Delete file from storage
        Storage::disk($media->disk)->delete($media->path);

        // Delete record
        $media->delete();

        return back()->with('success', 'Media deleted successfully');
    }
}
