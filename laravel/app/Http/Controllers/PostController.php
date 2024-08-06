<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth:api');
//    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Post::with('tags')->latest();

        if ($request->has('my_posts') && $request->boolean('my_posts')) {
            $query->where('user_id', $user->id);
        }

        return response()->json($query->get());
    }

    public function get_one($id)
    {
        $post = Post::with('tags')->findOrFail($id);

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:4096',
            'tags' => 'array',
            'tags.*' => 'string'
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'user_id' => Auth::id(),
        ]);

        $tags = array_map('strtolower', $validated['tags']);
        $tagIds = Tag::whereIn('name', $tags)->pluck('id')->toArray();

        foreach (array_diff($tags, Tag::pluck('name')->toArray()) as $tag) {
            $tagIds[] = Tag::create(['name' => $tag])->id;
        }

        $post->tags()->sync($tagIds);

        return response()->json($post->load('tags'), 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:4096',
            'tags' => 'array',
            'tags.*' => 'string'
        ]);

        $post->update($validated);

        $tags = array_map('strtolower', $validated['tags']);
        $tagIds = Tag::whereIn('name', $tags)->pluck('id')->toArray();

        foreach (array_diff($tags, Tag::pluck('name')->toArray()) as $tag) {
            $tagIds[] = Tag::create(['name' => $tag])->id;
        }

        $post->tags()->sync($tagIds);

        return response()->json($post->load('tags'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(null, 204);
    }
}
