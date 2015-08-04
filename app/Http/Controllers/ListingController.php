<?php namespace App\Http\Controllers;


use App\Housing;
use App\Institution;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Response;

class ListingController extends Controller {

	//
	
	 public function createnewlisting(Request $request)
    {
        $input = $request->only('price','address','duration','listing_details',
                                'amenities','property_name','property_type','rental_type','features','description',
                                'condition_rating','comments','image_path',
                                'primary_contact_name','primary_contact_number');
        
        
        $input['price'] = filter_var(filter_var($input['price'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['address'] = filter_var(filter_var($input['address'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['duration'] = filter_var(filter_var($input['duration'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['property_name'] = filter_var(filter_var($input['property_name'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['property_type'] = filter_var(filter_var($input['property_type'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['rental_type'] = filter_var(filter_var($input['rental_type'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['description']= filter_var(filter_var($input['description'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['condition_rating'] = filter_var(filter_var($input['condition_rating'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['primary_contact_name'] = filter_var(filter_var($input['primary_contact_name'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $input['primary_contact_number'] = filter_var(filter_var($input['primary_contact_number'], FILTER_SANITIZE_STRING), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        //validate the info, create rules for the inputs
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
           
        
            $newlisting = new Housing;
            $newlisting -> price = $input['price'];
            $newlisting -> address  = $input['address'];
            $newlisting ->duration = $input['duration'];
            //$newlisting ->listing_details = $email;
            //$newlisting ->amenities = $email;
            $newlisting ->property_name = $input['property_name'];
            $newlisting ->property_type = $input['property_type'];
            $newlisting ->rental_type = $input['rental_type'];
            //$newlisting -> features  = $input['address'];
            $newlisting ->description = $input['description'];
            $newlisting ->condition_rating = $input['condition_rating'];
            $newlisting ->comments = $input['comments'];
            //$newlisting ->image_path = ;
            $newlisting ->primary_contact_name = $input['primary_contact_name'];
            $newlisting ->primary_contact_number = $input['primary_contact_number'];
            $newlisting ->access_token = Auth::user()->access_token;
            $newlisting ->confirmation_code = $confirmation_code;
         

            // save new user
            $newlisting->save();
           
            return Response::json(array('response' => 'Registration Successful!'), 200);
        }
    }
    
    
    
    public function getlistingsforinstitution(Request $request)
    {
       $input = $request->only('i');
       $id= filter_var($input['i'], FILTER_SANITIZE_NUMBER_INT);
       //return Housing::get_housing_per_institution($id);
      return Response::json(Housing::get_housing_per_institution($id),200);
    }
    
     public function getdetailforlisting(Request $request)
    {
       $input = $request->only('i');
       $id= filter_var($input['i'], FILTER_SANITIZE_NUMBER_INT);
       //return Housing::get_housing_per_institution($id);
      return Response::json(Housing::get_housing_details($id),200);
    }
    
    public function getinstitutions()
    {
      return Institution::get_all_institutions();
    }

}
