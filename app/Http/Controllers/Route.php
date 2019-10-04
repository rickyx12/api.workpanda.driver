<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Route extends BaseController
{
    
    public function index($signboard) {

        $routes = DB::table('route')
                        ->where('signboard',$signboard)
                        ->get();

        return response()->json($routes,200);
    }

    public function add($signboard, Request $request) {

    	$name = $request->input('name');

    	$data = array(
                "name" => $name,
                "signboard" => $signboard
    		);

    	DB::table('route')->insert($data);

    	return response()->json($data,200);
    }

    public function update($signboard, $id, Request $request) {

    	$name = $request->input('name');

    	$data = array(
            "id" => $id,
            "signboard" => $signboard,
    		"name" => $name
    	);

    	DB::table('route')
    		->where('id',$id)
    		->where('signboard',$signboard)
    		->update($data);

    	return response()->json($data,200);	
    }

    public function delete($signboard, $id) {

        $data = array(
            "id" => $id,
            "signboard" => $signboard
        );

    	DB::table('route')
    		->where('id', $id)
            ->where('signboard', $signboard)
    		->delete();

    	return response()->json($data,200);
    }
}
