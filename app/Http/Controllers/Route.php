<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Route extends BaseController
{
    
    public function add(Request $request) {

    	$name = $request->input('name');
    	$signboard = $request->input('signboard');

    	$data = array(
                "name" => $name,
                "signboard" => $signboard
    		);

    	DB::table('route')->insert($data);
    }
}
