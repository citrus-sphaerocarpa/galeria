<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Post $post) {

            foreach ($post->comments as $comment)
            {
                $comment->delete();
            }
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->withTrashed()->whereNull('parent_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class);
    }
    
    public function tagging()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
