<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Specialties;

class SpecialitesController extends Controller
{
    public function index(){

        $specialties = Specialties::with('trans')->orderBy('sort', 'ASC')->active()->limit(8)->get();

        return view('site.pages.specialites.index', compact('specialties'));
    }
    

    public function show($slug = null){
        if(is_numeric($slug)){
            $specialty = Specialties::findOrFail($slug);
        }
        else{
            $specialty = Specialties::with('trans')->WhereTranslation('slug', $slug)->get()->first();
            if($specialty == null) abort('404');
        }

        $doctors = Doctor::with('trans')->where('specialty_id', $specialty->id)
            ->orderBy('sort', 'ASC')->active()->offset(0)->limit(4)->get();

        return view('site.pages.specialites.doctors', compact('specialty', 'doctors')); 
    }
}
