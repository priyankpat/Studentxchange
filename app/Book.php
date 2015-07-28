<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {

	//	//
	protected $table = 'books';
	protected $primaryKey = 'post_id';
	
	public static function get_courses_per_institution($input)
	{
	   return Book::select('post_id','course_code', 'course_name')->where('institution_id', '=', $input)->distinct()->get();
	}
	
	public static function get_books_per_course($id,$course)
	{
	   return Book::where('institution_id', '=', $id)
	   				->where('course_code', '=', $course)
	   				->get();
	}

}
