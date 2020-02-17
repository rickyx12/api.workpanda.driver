<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GuzzleHttp\Client;

class Auth extends BaseController
{
 
    public function index() {        
    
    }


    public function register(Request $request) {

        $username = $request->input('username');
        $password = $request->input('password');
    	$firstName = $request->input('first_name');
    	$lastName = $request->input('last_name');
    	$contactNo = $request->input('contact_no');
        $clientId = $request->input('client_id');
        $clientSecret = $request->input('client_secret');

    	$data = array(
                "username" => $username,
                "password" => Hash::make($password),
    			"first_name" => $firstName,
    			"last_name" => $lastName,
    			"contact_no" => $contactNo,
    		);

    	DB::table('user_profile')->insert($data);


        $client = new Client();        

        $reqToken = $client->request('POST','http://localhost/api.pickmeal/public/api/v1/oauth/token',[
            'json' => [
                'grant_type' => 'client_credentials',
                'scope' => '*',
                'client_id' => $clientId,
                'client_secret' => $clientSecret
            ]
        ]);

        $decodeToken = json_decode($reqToken->getBody(),true);

        $resp = array(
            'username' => $username,
            'token_type' => $decodeToken['token_type'],
            'expire_in' => $decodeToken['expires_in'],
            'access_token' => $decodeToken['access_token']
        );

        return response()->json($resp);
    }
  

    public function login(Request $request) {

        $username = $request->input('username');
        $password = $request->input('password');
        $clientId = $request->input('client_id');
        $clientSecret = $request->input('client_secret');

        $hashedPassword = DB::table('user_profile')
                        ->where('username', $username)
                        ->get(['password']);
        
        if(Hash::check($password, $hashedPassword[0]->password)) {

            $client = new Client();        

            $reqToken = $client->request('POST','http://localhost/api.pickmeal/public/api/v1/oauth/token',[
                'json' => [
                    'grant_type' => 'client_credentials',
                    'scope' => '*',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret
                ]
            ]);

            $decodeToken = json_decode($reqToken->getBody(),true);

            $resp = array(
                'username' => $username,
                'token_type' => $decodeToken['token_type'],
                'expire_in' => $decodeToken['expires_in'],
                'access_token' => $decodeToken['access_token']
            );
            
        }else {

            $resp = array('message' => 'error');
        }

        return response()->json($resp);
    }

}
