<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'show lectures', 'add lectures', 'edit lectures', 'delete lectures', 'access all lectures',
            'show lives', 'add lives', 'edit lives', 'delete lives', 'access all lives',
            'show quizzes', 'add quizzes', 'edit quizzes', 'delete quizzes', 'access all quizzes',
            'show courses', 'add courses', 'edit courses', 'delete courses', 'access all courses',
            'show registrations', 'add registrations', 'edit registrations', 'delete registrations',
            'upload grades',
            'show branches', 'add branches', 'edit branches', 'delete branches',
            'show invoices', 'delete invoices',
            'show colleges', 'add colleges', 'edit colleges', 'delete colleges',
            'show admissions', 'edit admissions', 'delete admissions',
            'show students', 'add students', 'edit students', 'delete students',
            'show tickets', 'add tickets', 'edit tickets', 'delete tickets',
            'show tickets', 'add tickets', 'edit tickets', 'delete tickets',
            'show blog_category', 'add blog_category', 'edit blog_category', 'delete blog_category',
            'show blog', 'add blog', 'edit blog', 'delete blog', 'access all blog',
            'show newsletters_subscribers', 'add newsletters_subscribers', 'edit newsletters_subscribers', 'delete newsletters_subscribers',
            'show pages', 'edit pages',
            'show questions', 'add questions', 'edit questions', 'delete questions',
            'show team_members', 'add team_members', 'edit team_members', 'delete team_members',
            'show contact_us', 'edit contact_us', 'delete contact_us',
            'show users', 'add users', 'edit users', 'delete users',
            'show roles', 'add roles', 'edit roles', 'delete roles',
            'show tasks', 'add tasks', 'edit tasks', 'delete tasks', 'access all tasks',
            'show chats', 'add chats', 'edit chats', 'delete chats',
            'show statistics',
            'show visitors_statistics',
            'show money_statistics',
            'show settings', 'edit settings',
            'access maintenance',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission], ['guard_name' => 'web']);
        }

        $rootRole = Role::firstOrCreate(['name' => 'root']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $permissions = Permission::pluck('name')->toArray();
        $rootRole->syncPermissions($permissions);
        $adminRole->syncPermissions($permissions);
    }
}
