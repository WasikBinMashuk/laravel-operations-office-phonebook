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
        $users = [];
        $phoneBook= [];
        for ($i = 1; $i <= $numberOfUsers; $i++) {
            $users[] = [
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            
            
        }

        // User::insert($users); 
        // $userIds = User::insertGetId($users);

        // Insert users into the database and get their IDs
        $insertedUsers = User::insert($users);

        // Retrieve the IDs of the inserted users
        $userIds = $insertedUsers->pluck('id')->all();


        for ($i = 1; $i <= $numberOfUsers; $i++){
            $id = 0;
            for($j = 1; $j <= 5010; $j++){
                $phoneBook[] = [
                    'name' => 'Contact ' . $i,
                    'mobile' => mt_rand(10000000000, 99999999999),
                    'address' => 'Mirpur' . $i,
                    'status' => rand(0,1),
                    'ownerId' => $userIds[$id],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'favourite' => rand(0,1)
                ];
            }
            $id++;
        }

        PhoneBook::insert($phoneBook);

        
        
    }
}
