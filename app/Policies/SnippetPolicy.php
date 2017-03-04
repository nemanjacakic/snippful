<?php

namespace App\Policies;

use App\User;
use App\Snippet;
use Illuminate\Auth\Access\HandlesAuthorization;

class SnippetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can create snippet.
     *
     * @param  \App\User  $user
     * @return bool
    */
    public function create(User $user)
    {
        return (bool) $user;
    }

    /**
     * Determine whether the user can manage the snippets.
     *
     * @param  \App\User  $user
     * @param  \App\Snippet  $snippet
     * @return mixed
     */
    public function manage(User $user, Snippet $snippet)
    {
        return $user->id === $snippet->user_id;
    }

}
