<?php

namespace App\Transformers;

use App\Snippet;
use App\Transformers\UserTransformer;
use League\Fractal\TransformerAbstract;

class SnippetTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'tags'
    ];

    public function transform(Snippet $snippet)
    {
        return [
            'id' => $snippet->id,
            'title' => $snippet->title,
            'body' => $snippet->body,
            'description' => $snippet->description,
            'mode' => $snippet->mode,
            'updatedAt' => $snippet->updated_at->toFormattedDateString()
        ];
    }

    public function includeTags(Snippet $snippet)
    {
        return $this->collection($snippet->tags, new TagTransformer);
    }
}
