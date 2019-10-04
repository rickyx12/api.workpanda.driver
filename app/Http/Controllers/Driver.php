<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Driver extends BaseController
{
 
    public function index() {

        $drivers = DB::table('driver')
                    ->get();

        return response()->json($drivers,200);            
    }

    public function information($id) {

        $driver = DB::table('driver')
                    ->where('id',$id)
                    ->get();

        return response()->json($driver,200);
    }

    public function register(Request $request) {

    	$firstName = $request->input('first_name');
    	$lastName = $request->input('last_name');
    	$middleName = $request->input('middle_name');
    	$plateNo = $request->input('plate_no');
    	$puvType = $request->input('puv_type');

    	$data = array(
    			"first_name" => $firstName,
    			"last_name" => $lastName,
    			"middle_name" => $middleName,
    			"plate_no" => $plateNo,
    			"puv_type" => $puvType
    		);

    	DB::table('driver')->insert($data);

        return response()->json($data,200);
    }


    public function update($id, Request $request) {

        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $middleName = $request->input('middle_name');
        $plateNo = $request->input('plate_no');
        $puvType = $request->input('puv_type');

        $data = array(
            "first_name" => $firstName,
            "last_name" => $lastName,
            "middle_name" => $middleName,
            "plate_no" => $plateNo,
            "puv_type" => $puvType
        );

        DB::table('driver')
            ->where('id',$id)
            ->update($data);

        return response()->json($data,200);
    }

    public function delete($id) {

        $data = array(
            'id' => $id
        );

        DB::table('driver')
            ->where('id',$id)
            ->delete();

        return response()->json($data,200);
    }

    public function activate($id) {

    	$data = array(
                "id" => $id,
    			"active" => 1
    		);

    	DB::table("driver")
    			->where('id',$id)
    			->update($data);

        return response()->json($data,200);
    }


    public function deactivate($id) {

    	$data = array(
                "id" => $id,
    			"active" => 0
    		);

    	DB::table("driver")
    			->where('id',$id)
    			->update($data);

        return response()->json($data,200);
    }

}
