<?php namespace App\Http\Controllers;


use App\Housing;
use App\Institution;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Response;

class ListingController extends Controller {

	//
	
	   public function getlistingsforinstitution(Request $request)
    {
       $input = $request->only('i');
       $id= filter_var($input['i'], FILTER_SANITIZE_NUMBER_INT);
       //return Housing::get_housing_per_institution($id);
      return Response::json(Housing::get_housing_per_institution($id),200);
    }
    
    public function getinstitutions()
    {
      return Institution::get_all_institutions();
    }

}
