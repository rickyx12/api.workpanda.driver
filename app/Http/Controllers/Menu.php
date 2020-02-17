<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Menu extends BaseController
{
 
    public function index($profile_id, $store_id) {

        $data = DB::table('menu')
                    ->where([
                        ['profile_id', '=', $profile_id],
                        ['store_id', '=', $store_id]
                    ])
                    ->get();

        return response()->json($data,200);          
    }


    public function add($profile_id, $store_id, Request $request) {

        $name = $request->input('name');
        $price = $request->input('price');
        $photo = $request->input('photo');
        $quantity = $request->input('quantity');

    	$data = array(
                "profile_id" => $profile_id,
                "store_id" => $store_id,
    			"name" => $name,
    			"price" => $price,
    			"photo" => $photo,
                "quantity" => $quantity
    		);

    	DB::table('menu')->insert($data);

        return response()->json($data,200);
    }


    public function update($profile_id, $store_id, $menu_id, Request $request) {

        $name = $request->input('name');
        $price = $request->input('price');
        $photo = $request->input('photo');
        $quantity = $request->input('quantity');

        $data = array(
            'name' => $name,
            'price' => $price,
            'photo' => $photo,
            'quantity' => $quantity
        );

        DB::table('menu')
            ->where([
                ['profile_id', '=', $profile_id],
                ['store_id', '=', $store_id],
                ['id', '=', $menu_id]
            ])
            ->update($data);

        return response()->json($data,200);
    }


    public function delete($profile_id, $store_id, $menu_id) {

        $data = DB::table('menu')
                ->where([
                    ['profile_id', '=', $profile_id],
                    ['store_id', '=', $store_id],
                    ['id', '=', $menu_id]
                ])
                ->delete();

        return response()->json($data,200);
    }


    public function order($store_id, $menu_id, Request $request) {

        $customerId = $request->input('customer_id');
        $quantity = $request->input('quantity');

        $data = array(
                'store_id' => $store_id,
                'menu_id' => $menu_id,
                'customer_id' => $customerId,
                'quantity' => $quantity
            );

        DB::table('orders')->insert($data);

        return response()->json($data,200);
    }

}
