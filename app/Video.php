<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = "videos";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status', 'video_path', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }
}
