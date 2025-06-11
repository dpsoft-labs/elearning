<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(100)->create();

        // for ($i = 0; $i < 100000; $i++) {
        //     $user = [
        //         'firstname' => fake()->name(),
        //         'lastname' => fake()->name(),
        //         'email' => fake()->unique()->safeEmail().$i,
        //         'password' => Hash::make('password'),
        //         'phone' => fake()->phoneNumber(),
        //         'email_verified_at' => now(),
        //     ];
        //     User::create($user);
        // }
        // إنشاء مستخدم Root
        $rootUser = new User();
        $rootUser->firstname = 'Root';
        $rootUser->lastname = 'User';
        $rootUser->email = 'root@dp-soft.com';
        $rootUser->password = Hash::make('Asd24688.');
        $rootUser->phone = '+200000000001';
        $rootUser->email_verified_at = now();
        $rootUser->save();

        // إنشاء مستخدم Admin
        $adminUser = new User();
        $adminUser->firstname = 'Admin';
        $adminUser->lastname = 'User';
        $adminUser->email = 'admin@admin.com';
        $adminUser->password = Hash::make('01000100');
        $adminUser->phone = '+200000000002';
        $adminUser->email_verified_at = now();
        $adminUser->save();

        // تعيين الأدوار للمستخدمين
        $rootRole = Role::where('name', 'root')->first();
        $adminRole = Role::where('name', 'admin')->first();

        $rootUser->assignRole($rootRole);
        $adminUser->assignRole($adminRole);
    }
}
