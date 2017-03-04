<?php

namespace App\Http\Controllers\Api;

use App\Snippet;
use App\Transformers\SnippetTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SnippetController extends ApiController
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
    public function index(Request $request)
    {
        $snippets = Snippet::whereUserId($this->user->id)->latest()->get();

        if (!$snippets->isEmpty()) {
            if ($this->user->cant('manage', $snippets->first())) {
                return $this->errorForbidden();
            }
        }

        return $this->respondWith($snippets, new SnippetTransformer, ['tags']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'title' => 'required|max:255',
            'description' => 'nullable|max:2000',
            'body' => 'required',
            'mode' => 'required|max:255',
            'tags' => 'array|exists:tags,id'
        ]);

        if ($validation->fails()) {
            return $this->errorWrongArgs($validation->errors());
        }

        $snippet = $this->user->snippets()->create([
            'title' => $request->title,
            'description' => $request->description,
            'body' => $request->body,
            'mode' => $request->mode
        ]);

        if ($this->user->cant('create', Snippet::class)) {
            return $this->errorForbidden();
        }

        $snippet->tags()->sync($request->tags);

        return $this->respondWith($snippet, new SnippetTransformer, ['tags']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Snippet $snippet)
    {
        if ($this->user->cant('manage', $snippet)) {
            return $this->errorForbidden();
        }

        return $this->respondWith($snippet, new SnippetTransformer, ['tags']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Snippet $snippet, Request $request)
    {
        if (!$snippet) {
            $this->errorInternalError();
        }

        if ($this->user->cant('manage', $snippet)) {
            return $this->errorForbidden();
        }

        $validation = Validator::make($request->all(),[
            'title' => 'required|max:255',
            'description' => 'nullable|max:2000',
            'body' => 'required',
            'mode' => 'required|max:255',
            'tags' => 'array|exists:tags,id'
        ]);

         if ($validation->fails()) {
            return $this->errorWrongArgs($validation->errors());
         }

        $snippet->update([
            'title' => $request->title,
            'description' => $request->description,
            'body' => $request->body,
            'mode' => $request->mode
        ]);

        $snippet->tags()->sync($request->tags);

        return $this->respondWith($snippet, new SnippetTransformer, ['tags']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Snippet $snippet)
    {
        if ($this->user->cant('manage', $snippet)) {
            return $this->errorForbidden();
        }

        $snippet = Snippet::destroy($snippet->id);

        return $this->respondWithArray(['error' => false]);
    }
}
