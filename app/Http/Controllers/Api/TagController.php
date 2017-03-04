<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use App\Transformers\TagTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::whereUserId($this->user->id)->get();

        if (!$tags->isEmpty()) {
            if ($this->user->cant('manage', $tags->first())) {
                return $this->errorForbidden();
            }
        }
        return $this->respondWith($tags, new TagTransformer);
    }

    public function show(Tag $tag)
    {
        if ($this->user->cant('manage', $tag)) {
            return $this->errorForbidden();
        }

        return $this->respondWith($tag, new TagTransformer, ['snippets']);
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'name' => 'required|max:255'
        ]);

        if ($validation->fails()) {
            return $this->errorWrongArgs($validation->errors());
        }

        if ($this->user->cant('create', Tag::class)) {
            return $this->errorForbidden();
        }

        $tag = $this->user->tags()->create([
            'name' => $request->name
        ]);

        return $this->respondWith($tag, new TagTransformer);
    }

    public function update(Tag $tag, Request $request)
    {
        if (!$tag) {
            $this->errorInternalError();
        }

        if ($this->user->cant('manage', $tag)) {
            return $this->errorForbidden();
        }

        $validation = Validator::make($request->all(),[
            'name' => 'required|max:255'
        ]);

        if ($validation->fails()) {
            return $this->errorWrongArgs($validation->errors());
        }

        $tag->update([
            'name' => $request->name,
        ]);

        return $this->respondWith($tag, new TagTransformer);
    }

    public function destroy(Tag $tag)
    {
        if ($this->user->cant('manage', $tag)) {
            return $this->errorForbidden();
        }

        $tag = Tag::destroy($tag->id);

        return $this->respondWithArray(['error' => false]);
    }
}
