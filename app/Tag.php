<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'user_id', 'name'
    ];

    public function snippets()
    {
        return $this->belongsToMany(Snippet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
