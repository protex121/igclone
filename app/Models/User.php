<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Overtrue\LaravelFollow\Traits\Followable;
use Overtrue\LaravelFollow\Traits\Follower;
use Overtrue\LaravelLike\Traits\Liker;
use BeyondCode\Comments\Contracts\Commentator;

class User extends Authenticatable implements HasMedia, Commentator
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, Followable, Follower, Liker, InteractsWithMedia;

    public const PAGINATE_COUNT = 20;

    protected $with = ['media'];
    protected $appends = ['avatar'];

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function needsCommentApproval($model): bool
    {
        return false;
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function comments()
    {
        return $this->hasMany(config('comments.comment_class'));
    }

    public function getAvatarAttribute($value)
    {
        $imageSize = 200;

        if (request()->is('users/*')) {
            $imageSize = 400;
        }

        return optional($this->getMedia('avatars')->last())->getUrl('thumb') ?? 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=' . $imageSize;
    }
}
