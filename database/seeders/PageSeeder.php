<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        // بيانات الصفحات
        $pages = [
            [
                'title' => 'Home',
            ],
            [
                'title' => 'About',
            ],
            [
                'title' => 'Privacy',
            ],
            [
                'title' => 'Terms',
            ],
        ];

        // إنشاء أو تحديث السجلات
        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['title' => $page['title']],
            );
        }
    }
}
