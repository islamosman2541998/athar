<?php

namespace App\Http\Requests\Api\Orders;

use Illuminate\Foundation\Http\FormRequest;

class CheckOutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "cart_cookie" => "nullable|string",

            /***********new added**************/
            'ship_to_me' => 'required|boolean',
            'know_receipent_address' => 'required_if:ship_to_me,0|boolean',
            'same_day' => 'nullable|integer|boolean',
            'delivery_date' => 'required_if:same_day,0',// here
            'specific_time_slot_status' => 'nullable|boolean',
            'specific_time' => 'required_if:specific_time_slot_status,1',
            'recepient_name' => 'required_if:know_receipent_address,1|string|min:2|max:255', // recepient name
            'recepient_mobile' => 'required_if:know_receipent_address,1|string|min:11|max:13',  //receipent mobile
            'delivery_place' => 'required_if:know_receipent_address,1|required_if:ship_to_me,1|boolean', //
            'area' => 'required_if:specific_time_slot_status,1|required_if:know_receipent_address,1|required_if:ship_to_me,1|string|min:2|max:255',
            'st_name' => 'required_if:know_receipent_address,1|required_if:ship_to_me,1|string|min:2|max:255',//
            'apartment' => 'required_if:know_receipent_address,1|required_if:ship_to_me,1|string|min:1|max:255',//
            'floor' => 'required_if:know_receipent_address,1|required_if:ship_to_me,1|string|min:1|max:255',//
            'greeting_card' => 'nullable|string',//
            'extra_instructions' => 'nullable|string',//
            'customer_first_name' => 'required|string|max:255|min:2',//  in database it is customer_name
            'customer_second_name' => 'required|string|max:255|min:2',//
            'customer_mobile' => 'required|string|max:13|min:11',//
            'customer_email' => 'required|email',//
            'hide_my_name_status' => 'nullable|boolean',
            'payment_method_id' => 'required_if:ship_to_me,1|integer|exists:payment_methods,id',//
            'promo_code' => 'nullable|string|min:2|max:151',
//            'shipping_cost', // not found in pages
//            'total', //
            /**********end new added *********/
            'image' => "nullable|" . ImageValidate(),  //deleted for now
        ];








    }
}
