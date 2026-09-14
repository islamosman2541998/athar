<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FaqCategoryTranslation extends Model {

    public $timestamps = false;

    protected $fillable = ['faq_category_id','locale','title'];
    
}
