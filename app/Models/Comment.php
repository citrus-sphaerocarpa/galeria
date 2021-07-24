<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    // protected static function boot()
    // {
    //     parent::boot();

    //     self::deleting(function (Comment $comment) {

    //         foreach ($comment->replies as $reply)
    //         {
    //             $reply->delete();
    //         }
    //     });
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->withTrashed();
    }
}
