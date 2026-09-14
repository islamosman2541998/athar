<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;
use App\Models\Specialties;
use App\Models\Doctor;
use Illuminate\Support\Facades\Cookie;

class Doctors extends Component
{
    public $specialties, $doctors, $start = 0, $count = 3;
    public $specialty_id = 0, $doctorsCount, $doctorsCarousels, $carouselIndex;

    public function mount()
    {
        $this->specialties = Specialties::with('trans')->orderBy('sort', 'ASC')->active()->get('id');

        $query = Doctor::with( ['trans' => function ($query) { $query->where('locale', app()->getLocale());}
            , 'specialty', 'specialty.trans' => function ($query) { $query->where('locale', app()->getLocale());}])->orderBy('sort', 'ASC')->active();

        $carouselIndex = 0;
        $this->doctorsCount = $query->count();
        $this->doctorsCarousels[$carouselIndex] = $query->offset($carouselIndex * $this->count)->limit($this->count)->get()->toArray();
         
    }


    public function updateSpecialty($specialty_id)
    {
        $this->specialty_id = $specialty_id;
        $this->doctorsCarousels = [];
        $this->updateDoctors();
    }


     /**
     * select the categories  of selected section
     */
    public function updateDoctors($carouselIndex = 0)
    {
        if($this->specialty_id == 0){
            $query = Doctor::with(['trans' => function ($query) { $query->where('locale', app()->getLocale());}
            , 'specialty', 'specialty.trans' => function ($query) { $query->where('locale', app()->getLocale());}]
            )->orderBy('sort', 'ASC')->active();
        }else{
            $query = Doctor::with(['trans' => function ($query) { $query->where('locale', app()->getLocale());}
            , 'specialty', 'specialty.trans' => function ($query) { $query->where('locale', app()->getLocale());}])
            ->where('specialty_id', $this->specialty_id)->orderBy('sort', 'ASC')->active();
        }
        
        $this->doctorsCount = $query->count();
        $this->doctorsCarousels[$carouselIndex] = $query->offset($carouselIndex * 3)->limit(3)->get()->toArray();
    }

    /**
     * load another num projets
    */
    public function loadDoctors(){
        $this->updateDoctors(count($this->doctorsCarousels));
    }


    public function render()
    {
        return view('livewire.site.doctors');
    }
}
