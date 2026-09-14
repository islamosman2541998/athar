<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\ServiceCategoryResource;
use App\Models\Occasion;
use App\Models\ServiceCategory;
use App\Models\ServiceCategoryTranslation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{

    /*# products list ##*/
    /*
     * show list of products with pagination links
     * list of product categories
     * list of occasions
     *
     * all lists above with   translation array of each of them as follows :
     * products has product_trans array
     * occasions has occasion_trans array
     * categories has product_category_trans array
     */
    public function index()
    {
        //  $locale = request()->header('lang') ?? 'en'; // Default to English if locale is not provided  
        $products = ServiceCategory::active()->feature()->orderBy('sort', 'ASC')->paginate($this->site_pagination_count);
        return $this->success(new PaginateResource(ServiceCategoryResource::collection($products)), __('messages.success'), 200);
    }




    /*# show product  ##*/
    /*
     *
 * show product with its related category and its multiple occasions  with their translations
 *
 * product has product_trans array
 * occasions related to product has occasion_trans array
 * category  related to product has product_category_trans array
 */

    public function show($id)
    {
//        $products = ServiceCategory::active()->feature()->with('galleryGroup' , 'page')->orderBy('sort', 'ASC')->paginate($this->site_pagination_count);
        $m = ServiceCategoryTranslation::with('serviceCategory')->where('slug', $id)->first();

        $product = 0;

        if ($m && $m->serviceCategory) {
            $product = $m->serviceCategory
                ->with('occasions.galleryGroup.images')
                ->active()->feature()->latest()->first();

        } else if (filter_var($id, FILTER_VALIDATE_INT) !== false && $id > 0) {
            $product = ServiceCategory::with( 'occasions.galleryGroup.images' )
                ->active()->feature()->find($id);
        }

        if (!$product) {
            return $this->error(__('message.site.not_found'), [], 404);
        }
        $productAll = new ServiceCategoryResource($product);
        return $this->success($productAll, __('messages.success'), 200);
    }




    /******************************************/
    /*# products search    ##*/

    /*
     * search by multiple occasions inputs (ids)   ex: (occasion[]) ,
     *   by multiple product_categories inputs (ids)    ex: (product_category[])
     *   by    from_price input    and     to_price input
     *   by    from_date input    and     to_date input
     *
     *
     *
     * show list of products with pagination links
     * list of product categories
     * list of occasions
     *
     * all lists above with   translation array of each of them as follows :
     * products has product_trans array
     * occasions has occasion_trans array
     * categories has product_category_trans array
     */

    public function search(Request $request)
    {
        $occasions = Occasion::active()->feature()->where('type', 1)->orderBy('sort', 'ASC')->get();

        $query = ServiceCategory::query()->active()->feature()->orderBy('sort', 'ASC');


        if (!empty($request->occasion) && $request->occasion[0] != null) {
            $occasions = is_array($request->occasion) ? $request->occasion : [$request->occasion];

            $query->whereRelation('occasions', function ($q) use ($occasions) {
                $q->whereIn('occassions.id', $occasions);
            });

        }


        /*************************search of price******************/


        /*************************search of date******************/
        if ($request->from_date && $request->to_date) {
            $from = date($request->from_date);
            $to = date($request->to_date);
            $query->whereBetween('created_at', [Carbon::parse($from), Carbon::parse($to)]);
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


        $items = $query->paginate();

        if ($items->count() < 1) {
            return $this->error(__('message.site.not_found'), [], 404);
        }

        return $this->paginate(ServiceCategoryResource::collection($items), __('messages.success'));
    }


}
