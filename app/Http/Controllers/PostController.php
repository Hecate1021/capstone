<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\TemporyImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function post()
    {
        // Fetch authenticated user
        $user = auth()->user();

        // Fetch posts created by the authenticated user with related files
        $posts = Post::with(['user', 'files'])
            ->where('user_id', $user->id) // Filter by the authenticated user's ID
            ->latest() // Get the latest posts
            ->get();

        // Pass data to the view
        return view('resort.post.post', compact('user', 'posts'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
        ]);

        $temporaryImages = TemporyImage::all();

        if ($validator->fails()) {
            foreach ($temporaryImages as $temporaryImage) {
                Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
                $temporaryImage->delete();
            }
            return redirect('/')->withErrors($validator)->withInput();
        }

        $post = new Post($validator->validated());
        $post->user_id = Auth::user()->id;
        $post->save();

        foreach ($temporaryImages as $temporaryImage) {
            $sourcePath = 'images/tmp/' . $temporaryImage->folder . '/' . $temporaryImage->file;
            $destinationPath = 'images/' . $temporaryImage->folder . '/' . $temporaryImage->file;

            Storage::copy($sourcePath, $destinationPath);

            File::create([
                'post_id' => $post->id,
                'file_name' => $temporaryImage->file,
                'file_path' => $temporaryImage->folder . '/' . $temporaryImage->file,
            ]);

            Storage::deleteDirectory('images/tmp/' . $temporaryImage->folder);
            $temporaryImage->delete();
        }

        return redirect()->route('resort.post')->with('success', 'Post created successfully.');
    }

    public function destroy(Request $request, Post $post)
    {
        // Ensure the authenticated user is authorized to delete the post
        if ($post->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete associated files from storage
        foreach ($post->files as $file) {
            Storage::delete('images/' . $file->file_path);
            Storage::deleteDirectory('images/' . dirname($file->file_path));
            $file->delete();
        }

        // Delete the post
        $post->delete();

        return response()->json(['success' => 'Post deleted successfully']);
    }

    public function view($id)
    {
        // Fetch the post with its files
        $post = Post::with('files')->findOrFail($id);

        // Prepare media files array with only images (filtering by extension)
        $mediaFiles = $post->files->filter(function ($file) {
            // Get the file extension (assuming 'file_name' is the actual file name field)
            $extension = pathinfo($file->file_name, PATHINFO_EXTENSION);
            // Only include image files
            return in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
        })->map(function ($file) {
            // Map the filtered files to their asset paths
            return [
                'path' => asset('storage/images/' . $file->file_path),
            ];
        });

        // Pass the post and media files to the view
        return view('resort.post.postview', compact('post', 'mediaFiles'));
    }


    public function viewpost($id)
    {
        $post = Post::with('files')->findOrFail($id);
        return view('postview', compact('post'));
    }
}
