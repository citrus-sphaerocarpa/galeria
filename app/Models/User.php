<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'username',
        'password',
        'notification_followed',
        'notification_message',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'name',
        'email',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    protected static function boot()
    {
        parent::boot();

        self::deleting(function (User $user) {

            foreach ($user->posts as $post)
            {
                $post->delete();
            }

            $user->profile()->delete();
            
            foreach ($user->messages as $message)
            {
                $message->delete();
            }

            foreach ($user->chatRooms as $chatRoom)
            {
                $chatRoom->delete();
            }

        });

        // Generate a profile
        static::created(function ($user){
            $user->profile()->create();
        });
    }


    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function favoriting()
    {
        return $this->belongsToMany(Post::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function chatRooms()
    {
        return $this->hasMany(ChatRoom::class);
    }
}
