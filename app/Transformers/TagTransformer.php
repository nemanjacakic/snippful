<?php

namespace App\Transformers;

use App\Tag;
use App\Transformers\UserTransformer;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'snippets'
    ];

    public function transform(Tag $tag)
    {
        return [
            'id' => $tag->id,
            'name' => $tag->name
        ];
    }

    public function includeSnippets(Tag $tag)
    {
        return $this->collection($tag->snippets, new SnippetTransformer);
    }
}
