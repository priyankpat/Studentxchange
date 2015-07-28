<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model {

	//
	protected $table = 'institution';
	protected $primaryKey = 'id';
	
	public static function get_all_institutions()
	{
	    return Institution::select('name','country')->get();
	}

}
