<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class CalculateAfterSale extends Component
{
    public $price   , $sale , $after_sale;
     public $model;

    public function mount(  $model = null) // to pass a parameter inside livewire blade compoonent
    {
         $this->model = $model;

        $this->price = $model->price ?? 0;
        $this->sale = $model->sale ?? 0;

        $this->price_after_sale = $model->price_after_sale ?? 0;

    }


    public function updatePrice()
    {
        $this->validate([
            'price' => 'required|numeric|min:0|max:1000000',
            'sale' => 'required|numeric|min:0|max:100',
            'price_after_sale' => 'nullable|numeric|min:0|max:1000000'
        ]);

        $this->price_after_sale =  +($this->price) - (+($this->price)  * (+($this->sale) / 100));

    }



    public function render()
    {
        return view('livewire.admin.calculate-after-sale');
    }
}
