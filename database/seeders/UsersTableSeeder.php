<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
        'name' => 'Alvin Faisal',
        'email' => 'alvin@gmail.com',
        'password' => Hash::make('password'),
        'remember_token' => null,
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s'),
      ],

      [
        'name' => 'John Cena',
        'email' => 'john@gmail.com',
        'password' => Hash::make('password'),
        'remember_token' => null,
        'created_at' => date('Y-m-d h:i:s'),
        'updated_at' => date('Y-m-d h:i:s'),
      ],
    ];

    User::insert($users);
  }
}
