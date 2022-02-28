<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Nette\Utils\Random;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleAndPermissionSeeder::class
        ]);

        User::factory(3)->hasPosts(3)->create();

        $admin = User::firstOrCreate(['name' => 'Admin'], [
            'password' => \Hash::make("Password"),
            'name' => 'Admin User',
            'email' => 'admin@guest-book.com'
        ]);

        $admin->assignRole('admin');
    }
}
