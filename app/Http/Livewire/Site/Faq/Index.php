<?php

namespace App\Http\Livewire\Site\Faq;

use App\Models\Faq;
use Livewire\Component;

class Index extends Component
{

    public $categories, $faq_questions;
    public $selectedCategory = 0;

    public function mount($categories){
        $this->categories = $categories;
        $this->faq_questions = Faq::with('translations', 'category.translations')->active()->get();
    }

    public function changeCategory($id){
        $this->selectedCategory = $id;
        if($id == 0){
            $this->faq_questions = Faq::with('translations', 'category.translations')->active()->get();
        }
        else{
            $this->faq_questions = Faq::with('translations', 'category.translations')->active()->where('faq_category_id', $id)->get();
        }
    }

    public function render()
    {
        return view('livewire.site.faq.index');
    }
}
