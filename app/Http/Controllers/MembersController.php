<?php
namespace App\Http\Controllers;

class MembersController extends Controller {

	/**
	 * Construct Members Page
	 *
	 * @return Response
	 */
	public function __construct() {
		
	}

	public function index() {
		return view('members');
	}
}