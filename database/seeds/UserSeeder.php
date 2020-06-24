<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User([
            'name' => 'Administrator',
            'email' => 'admin@domain.com',
            'password' => 'password',
        ]);

        $admin->is_admin = true;
        $admin->email_verified_at = now();

        $admin->save();
    }
}
