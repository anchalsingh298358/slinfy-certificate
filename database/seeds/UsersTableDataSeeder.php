<?php

use Illuminate\Database\Seeder;

class UsersTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
    		[
	    		'name' => 'Super Admin',
	    		'email' => 'superadmin@yopmail.com',
	    		'password' => Hash::make(12345678),
                'country_code' => NULL,
                'phone_number' => NULL,
	    		'role_id' => '1',
                'created_by' => '1',
	    		'created_at' => date('Y-m-d H:i:s')
    		],[
	    		'name' => 'Admin',
	    		'email' => 'admin@yopmail.com',
	    		'password' => Hash::make(12345678),
                'country_code' => NULL,
                'phone_number' => NULL,
	    		'role_id' => '2',
                'created_by' => '1',
	    		'created_at' => date('Y-m-d H:i:s')
    		],[
                'name' => 'Jack Jones',
                'email' => 'jack@yopmail.com',
                'password' => Hash::make(12345678),
                'country_code' => '91',
                'phone_number' => '7508068170',
                'role_id' => '3',
                'created_by' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ] ,[
                'name' => 'Jordan',
                'email' => 'jordan@yopmail.com',
                'password' => Hash::make(12345678),
                'country_code' => '91',
                'phone_number' => '1234567890',
                'role_id' => '3',
                'created_by' => '1',
                'created_at' => date('Y-m-d H:i:s')
            ] 
    	];

        //INSERT DATA INTO USERS ABLE
        \DB::table('users')->insert($users);
    }
}
