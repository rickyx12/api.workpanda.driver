<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Signboard extends BaseController
{
    
    public function add(Request $request) {

    	$name = $request->input('name');

    	$data = array(
                "name" => $name
    		);

    	DB::table('signboard')->insert($data);
    }
}
