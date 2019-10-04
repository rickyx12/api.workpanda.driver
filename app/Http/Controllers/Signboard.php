<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Signboard extends BaseController
{
    
    public function index($driver) {

        $signboards = DB::table('signboard')
                            ->get();

        return response()->json($signboards,200);
    }

    public function add($driver,Request $request) {

    	$name = $request->input('name');

    	$data = array(
    			"driver" => $driver,
                "name" => $name
    		);

    	DB::table('signboard')->insert($data);

    	return response()->json($data,200);
    }

    public function update($driver, $id, Request $request) {

    	$name = $request->input('name');

    	$data = array(
            "id" => $id,
            "driver" => $driver,
    		"name" => $name
    	);

    	DB::table('signboard')
    		->where('id',$id)
    		->where('driver',$driver)
    		->update($data);

    	return response()->json($data,200);
    }

    public function delete($driver, $id) {

    	$data = array(
    		"id" => $id,
            "driver" => $driver
    	);

    	DB::table('signboard')
    		->where('id',$id)
    		->where('driver',$driver)
    		->delete();

    	return response()->json($data,200);
    }
}
