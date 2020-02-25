<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'body', 'user_id', 'commentable_id', 'commentable_type',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function commentable(){
        return $this->morphTo();
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable')->orderBy('created_at','desc');
    }
}
