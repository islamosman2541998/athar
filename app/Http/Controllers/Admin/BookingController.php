<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingController extends Controller
{
 /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livewire.admin.booking.index');
    }

    public function show($id)
    {
        $item = Booking::findOrFail($id);
        return view('admin.dashboard.booking.show', compact('item'));
    }

}
