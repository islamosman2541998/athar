<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Contactus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livewire.admin.contact-us.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Contactus::findOrFail($id);
        $get_id_notifications = DB::table('notifications')->where('data->contact_id', $id)->pluck('id');
        foreach ($get_id_notifications as $id) {
            DB::table('notifications')->where('id', $id)->update(['read_at' => now()]);
        }
        return view('admin.dashboard.contact.show', compact('item'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function markAll()
    {

        $user = User::find(Auth::user()->id);
        $user->unreadNotifications->markAsRead();
        // foreach($user->unreadNotifications  as $notifications ){
        //     $notifications->markAsRead();
        //     return back();
        // }
        return back();
    }


    public function update_notification($id)
    {
        $contact = Contactus::findOrFail($id);
        $get_id_notifications = DB::table('notifications')->where('data->contact_id', $id)->pluck('id');
        foreach ($get_id_notifications as $id) {
            DB::table('notifications')->where('id', $id)->update(['read_at' => now()]);
        }
        return back();
    }
    public function read($id)
    {
        $contact = Contactus::findOrFail($id);
        $contact->update(['status', 1]);
        return back();
    }
}
