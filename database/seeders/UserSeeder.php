<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@example.com', 'password' => Hash::make('password')],
            ['name' => 'John', 'email' => 'john@example.com', 'password' => Hash::make('password')],
        ];

        foreach($users as $key=>$user) {
            $user = User::create($user);

            if($key == 0){
                Role::create(['name'=> 'admin']);
                $user->assignRole('admin');
            }else{
                Role::create(['name'=> 'client']);
                $user->assignRole('client');
            }

            
        }
    }
}
