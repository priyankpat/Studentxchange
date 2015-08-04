<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Housing extends Model {

	//
	protected $table = 'housing';
	protected $primaryKey = 'post_id';
	protected $hidden = ['access_token'];
	public static function get_housing_per_institution($input)
	{
	    return Housing::where('institution_id',$input)->get();
	}
	
	public static function get_housing_details($input)
	{
	    return Housing::where('post_id',$input)->get();
	}

}
