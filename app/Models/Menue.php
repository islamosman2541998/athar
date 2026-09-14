<?php

namespace App\Models;

use App\Enums\MenuPositionEnums;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;

class Menue extends Model
{
    use HasFactory,Translatable, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'position',
        'sort',
        'url',
        'type',
        'level',
        'dynamic_table',
        'dynamic_url',
        'status',
        'created_by',
        'updated_by',
    ];
    // foreign key
    protected $translationForeignKey = 'menue_id';
    // transatable table
    public $translatedAttributes = ['menue_id', 'locale', 'title', 'slug'];


    public function trans(){
        return $this->hasMany(MenueTranslation::class, 'menue_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(Menue::class,'parent_id', 'id');
    }
    public function children(){
        return $this->hasMany(Menue::class, 'parent_id', 'id')->orderBy('sort', 'ASC')->active();
    }

    public function childrenRecursive()
    {
        return $this->children()->with(['translations', 'childrenRecursive']);
    }

    public function getCurrentTitleAttribute(): string
    {
        return (string) ($this->translate(app()->getLocale())?->title
            ?? $this->translate(config('app.fallback_locale', 'en'))?->title
            ?? '');
    }

    public function getResolvedUrlAttribute(): string
    {
        $target = $this->type === 'dynamic'
            ? ($this->dynamic_url ?: $this->url)
            : ($this->url ?: $this->dynamic_url);

        if (!$target) {
            return '#';
        }

        if (Str::startsWith($target, ['http://', 'https://', 'mailto:', 'tel:', '#'])) {
            return $target;
        }

        return LaravelLocalization::localizeURL('/' . ltrim($target, '/'));
    }



    // Scopes ------------------------------------------------
    public function scopeActive($query){
        return $query->where('status', 1);
    }
    public function scopeMain($query){
        return $query->where('position', MenuPositionEnums::MAIN);
    }
    public function scopeFooter($query){
        return $query->where('position', MenuPositionEnums::FOOTER);
    }
    public function scopeParent($query){
        return $query->where('parent_id', null);
    }

}
