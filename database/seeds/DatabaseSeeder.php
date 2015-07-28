<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('InstitutionTableSeeder');
		$this->call('UserTableSeeder');
		$this->call('HousingTableSeeder');
		$this->call('BooksTableSeeder');
		
	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $users = array(
            array(
                'xchange_id'    => '1',
                'username'      => 'coolest_admin',
                'fullname'      => 'Cool Admin',
                'email'         => 'admin@example.org',
                'activated'        => '0',
                'institution_id'=> '1',
                'password'      => Hash::make('admin'),
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime,
                'remember_token'=> ''        
            ),
            array(
                'xchange_id'    => '2',
                'username'      => 'watertastesgood',
                'fullname'      => 'John Smith',
                'email'         => 'water@example.org',
                'activated'        => '0',
                'institution_id'=> '1',
                'password'      => Hash::make('water'),
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime,
                'remember_token'=> ''        
            ),
            array(
                'xchange_id'    => '3',
                'username'      => 'peacebeuponyou',
                'fullname'      => 'Amy Long',
                'email'         => 'peace@example.org',
                'activated'        => '0',
                'institution_id'=> '3',
                'password'      => Hash::make('peace'),
                'created_at'    => new DateTime,
                'updated_at'    => new DateTime,
                'remember_token'=> ''        
            )
        );

        DB::table('users')->insert( $users );
    }

}


class InstitutionTableSeeder extends Seeder {

    public function run()
    {
        DB::table('institution')->delete();

        $institutes = array(
            array(
                'id'        => '1',
                'name'      => 'Xchange University',
                'type'      => 'university',
                'city'      => 'oshawa',
                'country'   => 'Canada',
                'created_at'=> new DateTime,
                'updated_at'=> new DateTime
            ),
            array(
                'id'        => '2',
                'name'      => 'University of Ontario Institute of Technology',
                'type'      => 'university',
                'city'      => 'oshawa',
                'country'   => 'Canada',
                'created_at'=> new DateTime,
                'updated_at'=> new DateTime
            ),
             array(
                'id'        => '3',
                'name'      => 'Centennial College',
                'type'      => 'college',
                'city'      => 'scarborough',
                'country'   => 'Canada',
                'created_at'=> new DateTime,
                'updated_at'=> new DateTime
            ),
             array(
                'id'        => '4',
                'name'      => 'University of Toronto',
                'type'      => 'university',
                'city'      => 'toronto',
                'country'   => 'Canada',
                'created_at'=> new DateTime,
                'updated_at'=> new DateTime
            ),
             array(
                'id'        => '5',
                'name'      => 'Oxford University',
                'type'      => 'university',
                'city'      => 'oxford',
                'country'   => 'United Kingdom',
                'created_at'=> new DateTime,
                'updated_at'=> new DateTime
            ),
            array(
                'id'        => '6',
                'name'      => 'University of British Columbia',
                'type'      => 'university',
                'city'      => 'vancouver',
                'country'   => 'Canada',
                'created_at'=> new DateTime,
                'updated_at'=> new DateTime
            )
        );

        DB::table('institution')->insert( $institutes );
    }
}

class HousingTableSeeder extends Seeder {

    public function run()
    {
        DB::table('housing')->delete();
   
   
   
        $listings = array(
            array(
                'post_id'               => '1',
                'xchange_id'            => '3',
                'price'                 => 400.2,
                'institution_id'        => 2,
                'address'               => '2000 Simcoe Street North, Oshawa, Ontario',
                'duration'               => '8 months',
                'listing_details'       =>   "{'property_type': 'House','number_of_bedrooms': 4,'number_of_bathrooms': 2'furnished': 'no','pets allowed': 'no'}",
                'description'           => 'LALALALALAAAAAAAA',
                'amenities'             => "{'parking type': 'None','kitchen use': 'Yes','internet': 'High Speed', 'tv': 'yes','laundry': 'yes','cable tv': 'yes','pets allowed': 'no','wheelchair accesible': 'Yes', 'pool': 'No',}",
                'features'              => "Newly renovated kitchen with glass tile backsplash; Stainless steel kitchen appliances (ceramic top stove, fridge, dishwasher, microwave) ;  New windows (every window has been replaced) 
                                        ; Maintenance free – a service takes care of snow removal and lawn care",
                'views'                 => 4,
                'display_status'        => 1,
                'condition_rating'      => 2,
                'rank'                  => 4,
                'comments'              => "I am currently renovating this house and you will see some unfinished work in the pictures. All renovations will be completed before you move in. ",
                'image_path'            => "{'image_1': 'http://placehold.it/32x32'}",
                'primary_contact_name'  => 'Ahmed Dauda',
                'primary_contact_number'=> '6472256481',
                'created_at'            => new DateTime,
                'updated_at'            => new DateTime
            ),
             array(
                'post_id'               => '2',
                'xchange_id'            => '2',
                'price'                 => 400.2,
                'institution_id'        => 3,
                'address'               => '315 Niagara Drive, Oshawa, Ontario',
                'duraton'               => '8 months',
                'listing_details'       =>   "{'property_type': 'House','number_of_bedrooms': 4,'number_of_bathrooms': 2'furnished': 'no','pets allowed': 'no'}",
                'description'           => 'LALALALALAAAAAAAA',
                'amenities'             => "{'parking type': 'None','kitchen use': 'Yes','internet': 'High Speed', 'tv': 'yes','laundry': 'yes','cable tv': 'yes','pets allowed': 'no','wheelchair accesible': 'Yes', 'pool': 'No',}",
                'features'              => "Newly renovated kitchen with glass tile backsplash; Stainless steel kitchen appliances (ceramic top stove, fridge, dishwasher, microwave) ;  New windows (every window has been replaced) 
                                        ; Maintenance free – a service takes care of snow removal and lawn care",
                'views'                 => 11,
                'display_status'        => 1,
                'condition_rating'      => 2,
                'rank'                  => 4,
                'comments'              => "I am currently renovating this house and you will see some unfinished work in the pictures. All renovations will be completed before you move in. ",
                'image_path'            => "{'image_1': 'http://placehold.it/32x32'}",
                'primary_contact_name'  => 'Ahmed Dauda',
                'primary_contact_number'=> '6472256481',
                'created_at'            => new DateTime,
                'updated_at'            => new DateTime
            )
        );

        DB::table('housing')->insert( $listings );
    }
    
    

}


class BooksTableSeeder extends Seeder {

    public function run()
    {
        DB::table('books')->delete();
         
        $books = array(
            array(
                'post_id'               => 1,
                'xchange_id'            => 1,
                'price'                 => 400.2,
                'institution_id'        => 1,
                'title'                 => 'CCNA Routing and Switching',
                'author'                => 'Scott Empson',
                'course_code'           => "XXX",
                'course_name'           => "Advanced Networking",
                'publisher'             => "Cisco Press",
                'year'                  => 2013,
                'views'                 => 201,
                'type'                  => "used",
                'format'                => "paperback",
                'isbn_10'               => 1587204304,
                'isbn_13'               => 9781587204302,
                'edition'               => 3,
                'display_status'        => 1,
                'condition_rating'      => 5,
                'rank'                  => 4,
                'comments'              => "My name is written on the front page",
                'image_path'            => "{'image_1': 'http://placehold.it/32x32'}",
                'primary_contact_name'  => 'Ahmed Dauda',
                'primary_contact_number'=> '6472256481',
                'created_at'            => new DateTime,
                'updated_at'            => new DateTime
            ),
              array(
                'post_id'               => 2,
                'xchange_id'            => 2,
                'price'                 => 200.25,
                'institution_id'        => 1,
                'title'                 => 'Cisco Router Firewall Security',
                'author'                => 'Richard Deal',
                'course_code'           => "YYY",
                'course_name'           => "Security For Newbies",
                'publisher'             => "Cisco Press",
                'year'                  => 2004,
                'views'                 => 330,
                'type'                  => "new",
                'format'                => "hardcover",
                'isbn_10'               => 1587051753,
                'isbn_13'               => 9781587051753,
                'edition'               => 0,
                'display_status'        => 1,
                'condition_rating'      => 4,
                'rank'                  => 4,
                'comments'              => "I hated this book",
                'image_path'            => "{'image_1': 'http://placehold.it/32x32'}",
                'primary_contact_name'  => 'Josh Macintyre',
                'primary_contact_number'=> '6472256481',
                'created_at'            => new DateTime,
                'updated_at'            => new DateTime
            )
        );

        DB::table('books')->insert( $books );
    }
    
}
