<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Models\GalleryGroup;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolios extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'tag_id',
        'image',
        'video_url',
        'link',
        'sort',
        'status',
        'feature',
        'type',
        'created_by',
        'updated_by',
    ];
    protected $translationForeignKey = 'portfolio_id';
    public $translatedAttributes = [
        'portfolio_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_key',
    ];


    // relations ---------------------------------------------------------------------------------
    public function trans()
    {
        return $this->hasMany(PortfoliosTranslation::class, 'portfolio_id', 'id');
    }
    public function tag()
    {
        return $this->belongsTo(PortfolioTags::class, 'tag_id')->with('trans');
    }
public function transNow()
{
    return $this->hasOne(PortfoliosTranslation::class, 'portfolio_id')
                ->where('locale', app()->getLocale());
}
    public function projects()
    {
        return $this->hasMany(Projects::class, 'portfolio_id', 'id')->with('trans');
    }

    public function projectsactive()
    {
        return $this->hasMany(Projects::class, 'portfolio_id', 'id')->with('trans', 'images')->active()->orderBy('sort', 'ASC');
    }


    // Scopes ---------------------------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }
public function galleryGroup()
{
    return $this->hasOne(GalleryGroup::class, 'foreign_key')->where('type', 2)->latestOfMany();
}

public function galleryGroups()
{
    return $this->hasMany(GalleryGroup::class, 'foreign_key')->where('type', 2)->orderBy('id');
}

public function galleryMedia()
{
    return $this->hasManyThrough(
        Gallery::class,
        GalleryGroup::class,
        'foreign_key',
        'gallery_group_id',
        'id',
        'id'
    )->where('gallery_groups.type', 2)->orderBy('gallery_images.sort');
}
public function getYoutubeIdAttribute()
{
    if (!$this->link) {
        return null;
    }

    $url = trim($this->link);

    // youtube.com/shorts/VIDEO_ID
    if (preg_match('/youtube\.com\/shorts\/([^?&\/]+)/', $url, $matches)) {
        return $matches[1];
    }

    // youtube.com/watch?v=VIDEO_ID
    if (preg_match('/youtube\.com\/watch\?v=([^?&]+)/', $url, $matches)) {
        return $matches[1];
    }

    // youtu.be/VIDEO_ID
    if (preg_match('/youtu\.be\/([^?&\/]+)/', $url, $matches)) {
        return $matches[1];
    }

    // youtube.com/embed/VIDEO_ID
    if (preg_match('/youtube\.com\/embed\/([^?&\/]+)/', $url, $matches)) {
        return $matches[1];
    }

    return null;
}

public function getYoutubeEmbedUrlAttribute()
{
    if (!$this->youtube_id) {
        return null;
    }

    return 'https://www.youtube.com/embed/' . $this->youtube_id;
}

public function getIsYoutubeVideoAttribute()
{
    return !empty($this->youtube_id);
}
public function getYoutubeThumbnailAttribute()
{
    if (!$this->youtube_id) {
        return null;
    }

    return 'https://img.youtube.com/vi/' . $this->youtube_id . '/hqdefault.jpg';
}
public function path()
{
    return "/attachments/portfolio/";
}

public function pathInView()
{
    if ($this->image) {
        $candidates = [
            ltrim($this->image, '/'),
            ltrim($this->path() . $this->image, '/'),
            'storage/attachments/portfolio/' . ltrim($this->image, '/'),
        ];
        foreach ($candidates as $candidate) {
            if (file_exists(public_path($candidate))) {
                return '/' . $candidate;
            }
        }
    }

    return '/attachments/no_image/no_image.png';
}

    // YouTube ----------------------------------------------------------------------------------

    /** The YouTube link of the project: the dedicated field, or the project link when it points to YouTube. */
    public function youtubeSource(): ?string
    {
        return $this->video_url ?: $this->link;
    }

    /** Video id when the project uses a YouTube link instead of an uploaded file. */
    public function youtubeId(): ?string
    {
        $source = $this->youtubeSource();
        if (!$source) {
            return null;
        }

        preg_match(
            '~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~i',
            $source,
            $matches
        );

        return $matches[1] ?? null;
    }

    public function isYoutube(): bool
    {
        return $this->youtubeId() !== null;
    }

    /** Vertical YouTube Shorts need a portrait player. */
    public function isYoutubeShort(): bool
    {
        return $this->isYoutube() && str_contains(strtolower((string) $this->youtubeSource()), '/shorts/');
    }

    /** Public watch page, for the "watch on YouTube" button. */
    public function youtubeWatchUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id ? 'https://www.youtube.com/watch?v=' . $id : null;
    }

    /** Embed URL played inside the site (never sends the visitor to YouTube). */
    public function youtubeEmbedUrl(): ?string
    {
        $id = $this->youtubeId();

        return $id ? 'https://www.youtube-nocookie.com/embed/' . $id . '?rel=0&modestbranding=1&playsinline=1' : null;
    }

    /** Cover image taken from the YouTube video itself. */
    public function youtubeThumbnail(string $quality = 'maxresdefault'): ?string
    {
        $id = $this->youtubeId();

        return $id ? 'https://i.ytimg.com/vi/' . $id . '/' . $quality . '.jpg' : null;
    }
}
