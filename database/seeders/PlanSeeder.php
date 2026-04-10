<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'                   => 'Free',
                'slug'                   => 'free',
                'description'            => 'Perfect for trying out the platform.',
                'price_monthly'          => 0,
                'price_yearly'           => 0,
                'max_jobs'               => 3,
                'max_recruiters'         => 1,
                'featured_jobs_allowed'  => false,
                'has_analytics'          => false,
                'has_ats'                => false,
                'sort_order'             => 1,
            ],
            [
                'name'                   => 'Starter',
                'slug'                   => 'starter',
                'description'            => 'Great for small businesses and startups.',
                'price_monthly'          => 1500,
                'price_yearly'           => 15000,
                'max_jobs'               => 10,
                'max_recruiters'         => 2,
                'featured_jobs_allowed'  => false,
                'has_analytics'          => false,
                'has_ats'                => true,
                'sort_order'             => 2,
            ],
            [
                'name'                   => 'Professional',
                'slug'                   => 'professional',
                'description'            => 'For growing teams with serious hiring needs.',
                'price_monthly'          => 3500,
                'price_yearly'           => 35000,
                'max_jobs'               => null,
                'max_recruiters'         => 5,
                'featured_jobs_allowed'  => true,
                'has_analytics'          => true,
                'has_ats'                => true,
                'sort_order'             => 3,
            ],
            [
                'name'                   => 'Agency',
                'slug'                   => 'agency',
                'description'            => 'For recruitment agencies managing multiple clients.',
                'price_monthly'          => 7000,
                'price_yearly'           => 70000,
                'max_jobs'               => null,
                'max_recruiters'         => 20,
                'featured_jobs_allowed'  => true,
                'has_analytics'          => true,
                'has_ats'                => true,
                'sort_order'             => 4,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
