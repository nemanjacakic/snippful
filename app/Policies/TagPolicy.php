<?php

namespace App\Policies;

use App\User;
use App\Tag;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can create tag.
     *
     * @param  \App\User  $user
     * @return bool
    */
    public function create(User $user)
    {
        return (bool) $user;
    }

    /**
     * Determine whether the user can manage the tags.
     *
     * @param  \App\User  $user
     * @param  \App\Tag  $tag
     * @return mixed
     */
    public function manage(User $user, Tag $tag)
    {
        return $user->id === $tag->user_id;
    }
}
