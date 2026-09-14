<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = PaymentMethod::with('transNow')->get();
        return view('admin/dashboard/payment_methods/index', compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/dashboard/payment_methods/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $paymentMethod = PaymentMethod::create($request->except('qr_image', 'logo'));
        $paymentMethod->qr_image = $this->storeImage2($request, $paymentMethod->path(), $request->qr_image, 'qr_image');
        $paymentMethod->logo = $this->storeImage2($request, $paymentMethod->path(), $request->logo, 'logo');
        $paymentMethod->status = 'inactive';
        if ($request->status) {
            $paymentMethod->status = 'active';
        }

        $paymentMethod->save();
        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(route('admin.payment-methods.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        $paymentMethod->loads ?->trans;
        return view('admin/dashboard/payment_methods/show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        $paymentMethod->loads ?->trans;
        return view('admin/dashboard/payment_methods/edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
           $paymentMethod->update($request->except('qr_image', 'logo' , 'status'));
        if ($request->qr_image) {
            $paymentMethod->update(['qr_image' => $this->storeImage2($request, $paymentMethod->path(), $request->qr_image, 'qr_image')]);
        }
        if ($request->logo) {
            $paymentMethod->update(['logo' => $this->storeImage2($request, $paymentMethod->path(), $request->logo, 'logo')]);
        }

        if ($request->status  === 'active') {

            $paymentMethod->update(['status' =>"active"]);
        }else{
            $paymentMethod->update(['status' =>"inactive"]);
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        //
    }


    public function update_status($id)
    {
        $page = PaymentMethod::findOrfail($id);
        $page->status == 'active' ? $page->status = 'inactive' : $page->status =  'active';
        $page->save();
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $pages = PaymentMethod::findMany($request['record']);
            foreach ($pages as $page) {
                $page->update(['status' => 'active']);
            }
            session()->flash('success', trans('admin.status_changed_sucessfully'));
        }
        if ($request['unpublish'] == 1) {
            $pages = PaymentMethod::findMany($request['record']);
            foreach ($pages as $page) {
                $page->update(['status' => 'inactive']);
            }
            session()->flash('success', trans('admin.status_changed_sucessfully'));
        }
        return redirect()->back();
    }

}
