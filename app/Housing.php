<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Housing extends Model {

	//
	protected $table = 'housing';
	protected $primaryKey = 'post_id';
	public static function get_housing_per_institution($input)
	{
	    return Housing::where('institution_id',$input)->get();
	}

}
