<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update']);
    }

    public function index()
    {
        $posts = Post::with('user')->withTrashed()->paginate(10);

        $posts->each(function ($post) {
            $post->formatted_date = Carbon::parse($post->created_at)->format('Y-m-d H:i');
        });

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        // Check the number of posts created by the logged-in user
        $userPostsCount = Post::where('user_id', Auth::id())->count();

        if ($userPostsCount >= 3) {
            return redirect()->back()->withErrors(['error' => 'You can only create a maximum of 3 posts.']);
        }

        // Use the validated data from StorePostRequest
        $validated = $request->validated();

        // Create a new Post instance
        $post = new Post();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->slug = $this->generateUniqueSlug($validated['title']); // Generate unique slug
        $post->user_id = Auth::id(); // Assign the post to the authenticated user

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $post->image = $image->store('images', 'public'); // Save the image path
        }

        // Save the post
        $post->save();

        // Redirect with success message
        return redirect()->route('posts.index')->with('success', 'Post created successfully!');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post->formatted_created_at = Carbon::parse($post->created_at)->format('F j, Y');

        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $users = User::all(); // Fetch all users

        return view('posts.edit', compact('post', 'users'));
    }

    public function update(UpdatePostRequest $request, $id)
    {
        // Use the validated data from UpdatePostRequest
        $validated = $request->validated();

        $post = Post::findOrFail($id);
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        
        // Automatically generate and update slug
        $post->slug = $this->generateUniqueSlug($validated['title']); 

        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image) {
                \Storage::disk('public')->delete($post->image);
            }
            $image = $request->file('image');
            $post->image = $image->store('images', 'public');
        }

        $post->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully!');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    public function confirmDelete($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.confirm-delete', compact('post'));
    }

    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.index')->with('success', 'Post restored successfully.');
    }

    private function generateUniqueSlug($title)
    {
        $slug = \Illuminate\Support\Str::slug($title);
        $count = Post::where('slug', $slug)->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
}
