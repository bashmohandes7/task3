<?php

namespace App\Http\Controllers\Api\Post;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $posts = PostResource::collection(Post::paginate($this->paginateNumber));
        return $this->apiResponse($posts, 'All Posts Returned Successfully');

    }
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'description'  => $request->description,

        ]);
        return $this->createdResponse(new PostResource( $post));
    }
    public function show(Post $post)
    {
        if(!$post){
            return $this->notFoundResponse();
        }
        return $this->apiResponse(new PostResource( $post), 'Success');
    }
    public function update(Post $post, UpdatePostRequest $request)
    {
        if (!$post) {
            return $this->notFoundResponse();
        }
        $post->update([
            'title' => $request->title ?? $post->title,
            'description'  => $request->description ?? $post->description,
        ]);
        return $this->apiResponse(new PostResource( $post), 'Updated Successfully');

    }
    public function destroy(Post $post)
    {
        if (!$post) {
            return $this->notFoundResponse();
        }
        $post->delete();
        return $this->deleteResponse();

    }
}
