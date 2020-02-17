<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Store extends BaseController
{
 
    public function index($profile_id) {

        $store = DB::table('store')
                    ->where('profile_id', $profile_id)
                    ->get();

        return response()->json($store, 200);          
    }


    public function add($profile_id, Request $request) {

        $name = $request->input('name');
        $dropoffTime = $request->input('dropoff_time');
        $dropoffDate = $request->input('dropoff_date');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

    	$data = array(
                'profile_id' => $profile_id,
                'name' => $name,
                'dropoff_time' => $dropoffTime,
                'dropoff_date' => $dropoffDate,
                'longitude' => $longitude,
                'latitude' => $latitude
    		);

    	DB::table('store')->insert($data);

        return response()->json($data,200);
    }


    public function update($profile_id, $store_id, Request $request) {

        $name = $request->input('name');
        $dropoffTime = $request->input('dropoff_time');
        $dropoffDate = $request->input('dropoff_date');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        $data = array(
            "name" => $name,
            "dropoff_time" => $dropoffTime,
            "dropoff_date" => $dropoffDate,
            "longitude" => $longitude,
            "latitude" => $latitude
        );

        DB::table('store')
            ->where([
                ['profile_id', '=', $profile_id],
                ['id', '=', $store_id]
            ])
            ->update($data);

        return response()->json($data,200);
    }


    public function delete($profile_id, $store_id) {

    $data = DB::table('store')
            ->where([
                ['profile_id', '=', $profile_id],
                ['id', '=', $store_id]
            ])
            ->delete();

        return response()->json($data,200);
    }


    public function orders($store_id, Request $request) {

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
                        ['orders.store_id', $store_id],
                        ['is_delivered', $flag]
                    ])
                    ->get([
                        'user_profile.id',
                        'user_profile.last_name',
                        'user_profile.first_name',
                        'user_profile.contact_no',
                        'menu.name as order',
                        'menu.price',
                        'menu.quantity',
                        DB::raw('(menu.price*menu.quantity) as total')
                    ]);

        return response()->json($data, 200);
    }

}
