<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use BeyondCode\Comments\Traits\HasComments;
use Overtrue\LaravelLike\Traits\Likeable;
use Spatie\Image\Manipulations;

class Post extends Model implements HasMedia
{
    use HasFactory, HasComments, InteractsWithMedia, Likeable;

    public const PAGINATE_COUNT = 10;

    protected $fillable = [
        'user_id',
        'slug',
        'caption',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 400, 400)
            ->sharpen(10);

        $this->addMediaConversion('square')
            ->fit(Fit::Fill, 1080, 1080)
            ->background('ffffff');

        $this->addMediaConversion('meta-image')
            ->fit(Fit::Crop, 1200, 675)
            ->sharpen(10);
    }
}
