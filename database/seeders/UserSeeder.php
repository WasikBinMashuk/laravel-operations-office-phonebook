<?php

namespace Database\Seeders;

use App\Models\PhoneBook;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberOfUsers = 2000; 
        // $users = [];
        // $phoneBook= [];
        for ($i = 1; $i <= $numberOfUsers; $i++) {
            // users creation
            $users = User::create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            for($j = 1; $j <= 5000; $j++){
                // Contacts creation under every user

                //first 10 private contact
                if($j <= 10){
                    $status = 1;
                }
                else{
                    $status = 0;
                }

                PhoneBook::create([
                    'name' => 'Contact ' . $i,
                    'mobile' => mt_rand(10000000000, 99999999999),
                    'address' => 'Mirpur' . $i,
                    'status' => $status,      // 10 values with 1 and others 0
                    'ownerId' => $users -> id,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'favourite' => rand(0,1)    //atleast two values has to 1
                ]);
            }
        }
    }
}
