<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class About extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'image',
        'image_background',
        'ceo_image',
        'status',
        'sort',
        'created_by',
        'updated_by'
    ];

 
    public $translatedAttributes = [
        'title',
        'subtitle',
        'description',
        'sub_description',
        'our_story_title',
        'our_story_description',
        'ceo_title',
        'ceo_description',
        'vision',
        'mission',
        'at_a_glance',
    ];

    protected $translationForeignKey = 'about_id';

  
    public function trans()
    {
        return $this->hasMany(AboutTranslation::class, 'about_id', 'id');
    }

    public function transNow()
    {
        return $this->hasOne(AboutTranslation::class, 'about_id')->where('locale', app()->getLocale());
    }

    
    public function path()
    {
        return 'attachments/abouts/';
    }

    /**
     * Uploads are stored on the "public" disk with their folder included (e.g. "attachments/abouts/x.png").
     * Returns the public URL path, or null when the file is missing.
     */
    protected function storedFileInView(?string $file): ?string
    {
        return $file && Storage::disk('public')->exists($file) ? 'storage/' . $file : null;
    }

    public function imageInView()
    {
        return $this->storedFileInView($this->image);
    }

    public function imageBackgroundInView()
    {
        return $this->storedFileInView($this->image_background);
    }

    public function ceoImageInView()
    {
        return $this->storedFileInView($this->ceo_image);
    }
}
