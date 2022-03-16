<?php

namespace Database\Seeders;

use App\Models\DetailUser;
use Illuminate\Database\Seeder;

class DetailUserTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $detail_user =
      [
        [
          'users_id' => 1,
          'photo' => '',
          'role' => 'Web Developer',
          'contact_number' => '081233211344',
          'biography' => 'I, am a web developer',
          'created_at' => date('Y-m-d h:i:s'),
          'updated_at' => date('Y-m-d h:i:s'),
        ],

        [
          'users_id' => 2,
          'photo' => '',
          'role' => 'Apps Developer',
          'contact_number' => '081333444555',
          'biography' => 'I, am a Apps developer',
          'created_at' => date('Y-m-d h:i:s'),
          'updated_at' => date('Y-m-d h:i:s'),
        ],
      ];

    DetailUser::insert($detail_user);
  }
}
