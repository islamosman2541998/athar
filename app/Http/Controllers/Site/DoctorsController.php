<?php

namespace App\Http\Controllers\Site;

use App\Models\Doctor;
use App\Models\Reviews;
use App\Models\Specialties;
use App\Http\Controllers\Controller;

class DoctorsController extends Controller
{


    public function index()
    {
        $specialties = Specialties::with('trans')->orderBy('sort', 'ASC')->active()->get('id');

        
        $doctors = Doctor::with(['trans' => function ($query) { $query->where('locale', app()->getLocale());}
            , 'specialty', 'specialty.trans' => function ($query) { $query->where('locale', app()->getLocale());}])
            ->orderBy('sort', 'ASC')->active()->limit(6)->get();

       
        return view('site.pages.doctors.index', compact('specialties', 'doctors'));
    }



    public function show($slug = null)
    {
        if (is_numeric($slug)) {
            $doctor = Doctor::findOrFail($slug);
        } else {
            $doctor = Doctor::with('trans', 'specialty', 'specialty.trans')->WhereTranslation('slug', $slug)->get()->first();
            if ($doctor == null) abort('404');
        }

        $reviews = Reviews::with('trans')->orderBy('sort', 'ASC')->active()->feature()->limit(4)->get();

        return view('site.pages.doctors.show', compact('doctor', 'reviews'));
    }
}
