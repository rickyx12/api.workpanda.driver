<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Driver extends BaseController
{
    
    public function register(Request $request) {

    	$firstName = $request->input('firstName');
    	$lastName = $request->input('lastName');
    	$middleName = $request->input('middleName');
    	$plateNo = $request->input('plateNo');
    	$puvType = $request->input('puvType');

    	$data = array(
    			"first_name" => $firstName,
    			"last_name" => $lastName,
    			"middle_name" => $middleName,
    			"plate_no" => $plateNo,
    			"puv_type" => $puvType
    		);

    	DB::table('driver')->insert($data);

    }

    public function activate(Request $request) {

    	$id = $request->input("id");

    	$data = array(
    			"active" => 1
    		);

    	DB::table("driver")
    			->where('id',$id)
    			->update($data);
    }

    public function deactivate(Request $request) {

    	$id = $request->input("id");

    	$data = array(
    			"active" => 0
    		);

    	DB::table("driver")
    			->where('id',$id)
    			->update($data);
    }

}
