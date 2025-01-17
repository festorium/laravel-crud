<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\SystemLogService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $systemLogService;

    public function __construct(SystemLogService $systemLogService)
    {
        $this->systemLogService = $systemLogService;
    }

    // Create a new Post
    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'user_id' => auth()->id(),
        ]);

        // Log the create action
        $this->systemLogService->logActivity(
            auth()->id(),
            'CREATE_POST',
            'User created a new post with title: ' . $post->title
        );

        return apiResponse($post, 'Post created successfully', 201);
    }

    // Read all Posts
    public function index()
    {
        $posts = Post::all();

        // Log the read action
        $this->systemLogService->logActivity(
            auth()->id(),
            'READ_POSTS',
            'User viewed all posts'
        );

        return apiResponse($posts, 'Posts retrieved successfully');
    }

    // Read a single Post
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return apiErrorResponse('Post not found', 404);
        }

        // Log the read action
        $this->systemLogService->logActivity(
            auth()->id(),
            'READ_POST',
            'User viewed post with ID: ' . $post->id
        );

        return apiResponse($post, 'Post retrieved successfully');
    }

    // Update a Post
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return apiErrorResponse('Post not found', 404);
        }

        if ($post->user_id !== auth()->id()) {
            return apiErrorResponse('Unauthorized to update this post', 403);
        }

        $validatedData = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $post->update($validatedData);

        // Log the update action
        $this->systemLogService->logActivity(
            auth()->id(),
            'UPDATE_POST',
            'User updated post with ID: ' . $post->id
        );

        return apiResponse($post, 'Post updated successfully');
    }

    // Delete a Post
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return apiErrorResponse('Post not found', 404);
        }

        if ($post->user_id !== auth()->id()) {
            return apiErrorResponse('Unauthorized to delete this post', 403);
        }

        $post->delete();

        // Log the delete action
        $this->systemLogService->logActivity(
            auth()->id(),
            'DELETE_POST',
            'User deleted post with ID: ' . $post->id
        );

        return apiResponse(null, 'Post deleted successfully');
    }
}
