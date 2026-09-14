<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RateConteroller extends Controller
{

    public function index(Request $request)
    {

        $query = Rate::query()->with(['product' , 'order:id,identifier'])
            ->orderBy('id', 'DESC');


        /*************************search of date******************/
        if ($request->from_date && $request->to_date) {
            $from = date($request->from_date);
            $to = date($request->to_date);
            $query->whereBetween('created_at', [\Carbon\Carbon::parse($from), Carbon::parse($to)]);
        }
        if ($request->from_date != '' && $request->to_date == '') {
            $from = date($request->from_date);
            $to = now();
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        if ($request->to_date != '' && $request->from_date == '') {
            $from = date("1-1-2000");
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
        }

        /*************************search of date******************/


        if ($request->product != '') {
            $query = $query->whereHas('product', function ($q) {
                $q->whereTranslationLike('title', request()->input('product'));
            });
        }

        if ($request->order_id != '') {
            $query = $query->whereHas('order' , function ($q) {
                $q->where('id',request()->input('order_id'));
            });
        }

        $items = $query->paginate($this->pagination_count);
        $products = Product::latest()->get();
        $orders = Order::rated()->get();
        return view('admin/dashboard/rates/index', compact('items', 'products', 'orders'));
    }



    /**************test ************/

    /**************end test **********/


    public function show(Rate $rate)
    {
        return view('admin/dashboard/rates/show', compact('rate'));
    }


    public function edit(Rate $rate)
    {
        return view('admin/dashboard/rates/edit', compact('rate'));
    }



    public function update(Rate $rate, Request $request)
    {
        $rate->update($request->all());
        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }


    public function destroy(Rate $rate)
    {
        $rate->delete();
        session()->flash('danger', trans('message.admin.deleted_sucessfully'));
        return redirect(\LaravelLocalization::localizeURL(route('admin.rates.index')));
    }


    /***********################################################***************/

    public function actions(Request $request)
    {

        if ($request['delete_all'] == 1) {
            $rates = Rate::findMany($request['record']);
            foreach ($rates as $rate) {
                $rate->delete();
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }
        return redirect()->back();
    }


}
