<?php

namespace App\Http\Controllers;

use App\Http\Transformers\PostTransformer;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\DataArraySerializer;

class AdminController extends Controller
{
    public function show(Request $request)
    {
        $paginator = Post::with([
            'user',
            'children'
        ])
        ->doesntHave('parent')
        ->orderBy('created_at', 'desc')->paginate(5);

        $manager = new Manager();
        // $manager->parseIncludes(['user', 'children']);
        $manager->setSerializer(new DataArraySerializer);

        $resource = new Collection($paginator->items(), new PostTransformer());
        $posts = $manager->createData($resource)->toArray();

        $posts = new LengthAwarePaginator($posts, $paginator->total(), $paginator->perPage(), $paginator->currentPage(), $paginator->getOptions());
        return Inertia::render('AdminDashboard', [
            'posts' => $posts,
            'sendReplyRoute' => url('/reply')
        ]);
    }
}
