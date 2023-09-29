<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class HomologarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->username = $user->email;
            $user->save();
        }
    }
}
