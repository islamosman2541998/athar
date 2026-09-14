<?php

namespace App\Services;

use App\Models\Gallery;
use App\Models\Slider;
use App\Models\Specialties;
use App\Models\Video;
use App\Settings\HomeSettingSingleton;
use App\Settings\SettingSingleton;

class HomeService
{
    public $sliders, $specialties, $reviews, $gallries, $videos;

    public $modelHomeSetting, $settings, $services, $brand_image, $tags, $portfolios, $blogs;


    public function __construct()
    {

        $this->sliders = new Slider();
        $this->specialties = new Specialties();
        $this->gallries = new Gallery();
        $this->videos = new Video();

        $this->modelHomeSetting = HomeSettingSingleton::getInstance();
        $this->settings = SettingSingleton::getInstance();
    }

    // get Data --------------------------------------------------------------------------------------------------

    function getSlidersData()
    {
        return $this->sliders->with('trans')->orderBy('sort', 'ASC')->active()->get();
    }

    function getSpecialtiesData()
    {
        return $this->specialties->with('trans')->orderBy('sort', 'ASC')->active()->feature()->limit(8)->get();
    }


    function getGalleriesData()
    {
        return $this->gallries->with('trans')->orderBy('sort', 'ASC')->active()->feature()->limit(3)->get();
    }

    function getVideosData()
    {
        return $this->videos->with('trans')->orderBy('sort', 'ASC')->active()->feature()->limit(3)->get();
    }

    function getHomeMeetDoctor()
    {
        return  $this->modelHomeSetting->getItem('meet-our-doctors');
    }
    function getHomeMission()
    {
        return  $this->modelHomeSetting->getItem('mission');
    }

    function getHomeMakeAppointment()
    {
        return $this->modelHomeSetting->getItem('make-an-appointments');
    }
    function getHomeInsurance()
    {
        return $this->modelHomeSetting->getItem('insurance');
    }

    function getHomeVisions()
    {
        return $this->modelHomeSetting->getItem('our-visions');
    }

    function index()
    {
        $data['sliders'] = $this->getSlidersData();
        $data['specialties'] = $this->getSpecialtiesData();
        $data['galleries'] = $this->getGalleriesData();
        $data['videos'] = $this->getVideosData();

        $data['meetDoctor'] = $this->getHomeMeetDoctor();
        $data['mission'] = $this->getHomeMission();
        $data['makeAppointment'] = $this->getHomeMakeAppointment();
        $data['insurance'] = $this->getHomeInsurance();
        $data['visions'] = $this->getHomeVisions();
        $data['settings'] = $this->settings;

        return $data;
    }
}
