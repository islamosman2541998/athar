<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Partner extends Model
{
    use Translatable, SoftDeletes;

    protected $fillable = [
        'image', 'url', 'status', 'sort', 'created_by', 'updated_by'
    ];

    public $translatedAttributes = ['title'];
    protected $translationForeignKey = 'partner_id';

    // helper paths — uploads are stored on the "public" disk (storage/app/public/attachments/partners)
    public function path() { return 'attachments/partners/'; }

    public function hasImage(): bool
    {
        return $this->image && Storage::disk('public')->exists($this->path() . $this->image);
    }

    public function pathInView()
    {
        if ($this->hasImage()) {
            return 'storage/' . $this->path() . $this->image;
        }
        return '/attachments/no_image/no_image.png';
    }
}
