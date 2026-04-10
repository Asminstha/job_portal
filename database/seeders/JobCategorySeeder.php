<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Information Technology', 'slug' => 'it',           'icon' => '💻', 'sort_order' => 1],
            ['name' => 'Design & Creative',      'slug' => 'design',       'icon' => '🎨', 'sort_order' => 2],
            ['name' => 'Marketing & Sales',      'slug' => 'marketing',    'icon' => '📢', 'sort_order' => 3],
            ['name' => 'Finance & Accounting',   'slug' => 'finance',      'icon' => '💰', 'sort_order' => 4],
            ['name' => 'Human Resources',        'slug' => 'hr',           'icon' => '👥', 'sort_order' => 5],
            ['name' => 'Customer Support',       'slug' => 'support',      'icon' => '🎧', 'sort_order' => 6],
            ['name' => 'Engineering',            'slug' => 'engineering',  'icon' => '⚙️', 'sort_order' => 7],
            ['name' => 'Healthcare',             'slug' => 'healthcare',   'icon' => '🏥', 'sort_order' => 8],
            ['name' => 'Education',              'slug' => 'education',    'icon' => '📚', 'sort_order' => 9],
            ['name' => 'Legal',                  'slug' => 'legal',        'icon' => '⚖️', 'sort_order' => 10],
            ['name' => 'Operations',             'slug' => 'operations',   'icon' => '📋', 'sort_order' => 11],
            ['name' => 'Others',                 'slug' => 'others',       'icon' => '🔖', 'sort_order' => 12],
        ];

        foreach ($categories as $cat) {
            JobCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
