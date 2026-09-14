<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppContact;
use App\Traits\FileHandler;
use Illuminate\Http\Request;
use function Symfony\Component\Mime\Header\all;

class WhatsAppContactController extends Controller
{
    use FileHandler;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = WhatsAppContact::with('transNow')->get();

        return view('admin/dashboard/whatsapp_contacts/index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/dashboard/whatsapp_contacts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $whats = WhatsAppContact::create($request->except('image'));
        $whats->image = $this->storeImage2($request, $whats->path(), $request->image, 'image');
        $whats->save();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(route('admin.whatsapp-contact.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\WhatsAppContact $whatsAppContact
     * @return \Illuminate\Http\Response
     */
    public function show(WhatsAppContact $whatsAppContact)
    {
        //
    }


    public function edit($id)
    {
        $whatsapp = WhatsAppContact::find($id);
        return view('admin/dashboard/whatsapp_contacts/edit', compact('whatsapp'));
    }


    public function update(Request $request, $id)
    {
        $whatsapp = WhatsAppContact::where('id', $id)->first();
        if (!$whatsapp) {
            session()->flash('error', trans('message.admin.not_found'));
            return redirect()->back();
        }

        $whatsapp->update($request->except('image'));
        if ($request->image) {
            $whatsapp->image = $this->storeImage2($request, $whatsapp->path(), $request->image, 'image');
            $whatsapp->save();
        }
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\WhatsAppContact $whatsAppContact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $whatsapp = WhatsAppContact::find($id);
        if (!$whatsapp) {
            session()->flash('error', trans('message.admin.deleted_successfully'));
            return redirect()->back();
        }
        @unlink(  public_path() . $whatsapp->path() . $whatsapp->image);
        $whatsapp->delete();

        session()->flash('error', trans('message.admin.deleted_successfully'));
        return  redirect()->back();

    }



    public function update_status($id)
    {
        $news = WhatsAppContact::findOrfail($id);
        $news->status == 1 ? $news->status = 0 : $news->status = 1;
        $news->save();
        return redirect()->back();
    }

    public function update_feature($id)
    {
        $news = WhatsAppContact::findOrfail($id);
        $news->feature == 1 ? $news->feature = 0 : $news->feature = 1;
        $news->save();
        return redirect()->back();
    }



    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $news = WhatsAppContact::findMany($request['record']);
            foreach ($news as $new) {
                $new->update(['status' => 1]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $news = WhatsAppContact::findMany($request['record']);
            foreach ($news as $new) {
                $new->update(['status' => 0]);
            }
            session()->flash('success', trans('articles.status_changed_sucessfully'));
        }
        if ($request['delete_all'] == 1) {
            $news = WhatsAppContact::findMany($request['record']);
            foreach ($news as $new) {
                @unlink($new->image);
                $new->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }

}
