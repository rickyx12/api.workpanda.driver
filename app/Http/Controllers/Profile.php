<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class Profile extends BaseController
{
 
    public function index($profile_id) {

        $data = DB::table('user_profile')
                    ->where('id', $profile_id)
                    ->get();

        return response()->json($data,200);         
    }


    public function update($profile_id, Request $request) {

        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $contactNo = $request->input('contact_no');

        $data = array(
            "first_name" => $firstName,
            "last_name" => $lastName,
            "contact_no" => $contactNo
        );

        DB::table('user_profile')
            ->where('id', $profile_id)
            ->update($data);

        return response()->json($data,200);
    }


    public function orders($profile_id, Request $request) {

        $isDelivered = $request->input('is_delivered');
        $flag = 0;

        if($isDelivered) {
            $flag = 1;
        }else {
            $flag = 0;
        }

        $data = DB::table('orders')
                    ->join('store', 'orders.store_id', '=', 'store.id')
                    ->join('menu', 'orders.menu_id', '=', 'menu.id')
                    ->join('user_profile', 'orders.customer_id', '=', 'user_profile.id')
                    ->where([
                        ['orders.customer_id', $profile_id],
                        ['is_delivered', $flag]
                    ])
                    ->get([
                        'store.id as store_id',
                        'store.name as store', 
                        'menu.name as menu', 
                        'menu.price', 
                        'menu.quantity', 
                        DB::raw('menu.price*menu.quantity as total'),
                        'store.dropoff_time',
                        'store.dropoff_date',
                        'store.longitude',
                        'store.latitude'
                    ]);

        return response()->json($data, 200);
    }    
}
