<?php

namespace App\Http\Controllers;

use App\Http\Transformers\PostTransformer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\JsonApiSerializer;

class CommentsController extends Controller
{
    public function __construct()
    {
        
    }

    public function createComment(Request $request)
    {
        $request->validate([
            'comment' => 'required|string'
        ]);

        $post = new Post(['description' => $request->comment]);
        $post->user()->associate(Auth::user());
        $post->save();

        return redirect('dashboard');
    }

    public function getComments() 
    {
        $posts = Post::whereHas('user', function($q) {
            $q->where('id', Auth::user()->id);
        })->get();

        return $posts;
    }

    function show() 
    {
        /** @var \App\Models\User */
        $user = Auth::user();
        $paginator = $user->posts()->with([
            'user',
            'children'
        ])
        ->doesntHave('parent')
        ->orderBy('created_at', 'desc')->paginate(5);

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer);

        $resource = new Collection($paginator->items(), new PostTransformer());
        $posts = $manager->createData($resource)->toArray();

        $posts = new LengthAwarePaginator($posts, $paginator->total(), $paginator->perPage(), $paginator->currentPage(), $paginator->getOptions());

        return Inertia::render('Dashboard', [
            'posts' => $posts,
            'sendReplyRoute' => url('/reply'),
            'createCommentRoute' => url('/comment')
        ]);
    }

    public function reply(Request $request, Post $post) 
    {
        $request->validate([
            'comment' => 'required|string'
        ]);

        $user = Auth::user();
        $reply = new Post();
        $reply->description = $request->comment;
        $reply->user()->associate($user);
        $reply->parent()->associate($post);
        $reply->save();
    }

    public function delete(Request $request, Post $post)
    {
        $post->delete();
    }
}
