<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Response;

class AuthController extends Controller
{

    public function login(Request $request) {
        $input = $request->only('email', 'password');
        
        if(Auth::attempt($input))
        {
        	// Auth::user()
        	return Response::json(array('response' => 'Successfull Login'), 200);
        } else {
        	return Response::json(array('flash' => 'Invalid Username or Password'), 500);
        }
    }

    public function token() {
    	return csrf_token();
    }

    public function logout() {
    	Auth::logout();
    	return Response::json(array('flash' => 'See You Next Time!'));
    }
}
