<?php namespace App\Http\Controllers;

use App\Book;
use App\Institution;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class LibraryController extends Controller {

	public function getuniversitycourses(Request $request)
    {
       $input = $request->only('i');
       $id= filter_var($input['i'], FILTER_SANITIZE_NUMBER_INT);
       return Book::get_courses_per_institution($id);
    }
    
    public function getbooksforcourse(Request $request)
    {
       $input = $request->only('i','c');
       $id= filter_var($input['i'], FILTER_SANITIZE_NUMBER_INT);
       $course= filter_var($input['c'], FILTER_SANITIZE_STRING);
       return Book::get_books_per_course($id,$course);
    }

}
