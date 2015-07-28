<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Response;
use DB;
use Validator;
use Hash;
use Storage;
use Mail;

class AuthController extends Controller
{
    
    public function login(Request $request) {
        $input = $request->only('email', 'password');
        
        if(Auth::attempt($input))
        {
        	// Auth::user()
        	return Response::json(array('response' => 'Successful Login'), 200);
        } else {
        	return Response::json(array('flash' => 'Invalid Username or Password'), 500);
        }
    }

    public function token() {
    	return csrf_token();
    }
    
    
    public function validateUsername(Request $request)
    {
        $input = $request->only('username');
        
        $rules = array('username' => 'unique:users,username');
        
        $validator = Validator::make($input, $rules);
        
        if($validator->fails())
        	return Response::json(array('flash' => 'Username Already Exists!'), 500);
        else
            return Response::json(array('response' => 'true'), 200);
    }
    
     public function validateEmail(Request $request) 
     {
        $input = $request->only('email');
        
        $rules = array('email' => 'unique:users,email');
        
        $validator = Validator::make($input, $rules);
        
        if($validator->fails())
        	return Response::json(array('flash' => 'Email Already Exists!'), 500);
        else
            return Response::json(array('response' => 'true'), 200);
     }

    public function logout() {
    	Auth::logout();
    	return Response::json(array('flash' => 'See You Next Time!'));
    }
    
    public function register(Request $request)
    {
        $input = $request->only('fullname','email', 'role','username','password');
        
        $fullname = filter_var(filter_var($input['fullname'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var(filter_var($input['email'], FILTER_SANITIZE_EMAIL), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $role = filter_var(filter_var($input['role'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var(filter_var($input['username'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = str_random(8); 
         
         // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', 
            'username' => 'required|string|min:3|max:20', 
            'fullname' => 'required|string|max:60',
            'role' => 'required|in:student,landlord', 
        );
        
        // run the validation rules on the inputs from the form
        $validator = Validator::make($input, $rules);
        
        // if the validator fails, redirect back to the form
        if ($validator->fails()) 
           return Response::json(array('flash' => $validator->messages()->all(), 500));
        else
        {
            $confirmation_code = str_random(30);
           //
           //compose email here -- writing to file instead
            Storage::append('register.txt', $fullname .":". $username . ":" . $email . ":" . $password . ":" . $role ."\n");
            
            
            $newuser = new User;
            $newuser->institution_id = 1;
            $newuser->fullname  = $fullname;
            $newuser->username = $username;
            $newuser->email = $email;
            $newuser->password  = Hash::make($password);
            $newuser->confirmation_code = $confirmation_code;
            $newuser->role= $role;
            
            Mail::send('emails.verify', $confirmation_code, function($message) {
            $message->to($email, $username)
                ->subject('Verify your email address');
            });


            // save new user
            $newuser->save();
           
            return Response::json(array('response' => 'Registration Successful!'), 200);
        }
          // return "6addd";
        
    }
}
