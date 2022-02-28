<?php

namespace App\Http\Transformers;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract {

    protected $defaultIncludes = [
        'user',
        'children'
    ];

    public function transform(Post $post) 
    {
        $result = [
            'id' => $post->id,
            'description' => $post->description,
            'created_at' => $post->created_at->toDateTimeString()
        ];

        return $result;
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }

    public function includeChildren(Post $post)
    {
        return $this->collection($post->children, new PostTransformer);
    }
}