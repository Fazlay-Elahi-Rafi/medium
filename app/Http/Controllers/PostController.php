<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Post::latest();

        $categories = Category::get();

        $posts = $query->paginate(4);
        return view('post.index', [
            'categories' => $categories,
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view('post.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Display Post of my
     */
    public function myPost()
    {
        $categories = Category::get();
        $posts = auth()->user()->posts()->latest()->paginate(4);

        return view('post.myPost', [
            'categories' => $categories,
            'posts' => $posts
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =  $request->validate([
            'title' => 'required',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2MB max
            'category_id' => ['required', 'exists:categories,id'], // This must be present and correspond to an existing id in the categories table.
            'published_at' => ['nullable', 'datetime'],
        ]);

        $image = $data['image']; // Extracts the uploaded image file from the validated data.
        unset($data['image']); // Temporarily removes the image from $data to avoid errors when creating the post, because the image is a file and needs special handling
        $data['user_id'] = Auth::id(); // Adds the ID of the currently authenticated user to the post data, associating the post with the user who created it.
        $data['slug'] = Str::slug($data['title']);

        $imagePath = $image->store('posts', 'public'); // Saves the uploaded image in the storage/app/public/posts folder.
        $data['image'] = $imagePath;

        Post::create($data);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {
        return view('post.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::get();

        return view('post.edit', [
            'categories' => $categories,
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Validate the request
        $data = $request->validate([
            'title' => 'required',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => ['required', 'exists:categories,id'],
            'published_at' => ['nullable', 'datetime'],
        ]);

        
        $data['user_id'] = Auth::id();

        // Handle image upload
        if ($data['image'] ?? false) {
            // Delete old image if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // Store new image
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        // Update the post
        $post->update($data);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete the image from storage if it exists
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('dashboard');
    }

    /**
     * Pagination Post by Category
     */
    public function category(Category $category)
    {
        $post = $category->posts()->latest()->simplePaginate(5);

        return view('post.index', [
            'posts' => $post,
        ]);
    }
}
