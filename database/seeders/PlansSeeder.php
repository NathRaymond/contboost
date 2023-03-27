<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Usecase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('plans')->count() == 0) {
            $plans = [
                [
                    'name' => 'Basic I',
                    'description' => 'Basic plan for students.',
                    'status' => true,
                    'is_support' => true,
                    'monthly_price' => 4.99,
                    'yearly_price' => 49.99,
                    'no_of_words' => 5000,
                    'usecase_daily_limit' => 50,
                ],
                [
                    'name' => 'Classic',
                    'description' => 'Best plan for individuals and small teams.',
                    'status' => true,
                    'is_support' => true,
                    'monthly_price' => 9.99,
                    'yearly_price' => 99.99,
                    'no_of_words' => 20000,
                    'usecase_daily_limit' => 100,
                ],
                [
                    'name' => 'Professional',
                    'description' => 'Best plan for large teams.',
                    'status' => true,
                    'is_support' => true,
                    'monthly_price' => 24.99,
                    'yearly_price' => 249.99,
                    'no_of_words' => 50000,
                    'usecase_daily_limit' => 250,
                ],
            ];

            foreach ($plans as $plan) {
                $plan = Plan::create($plan);

                $usercases = Usecase::all()->pluck('id');
                $plan->usecases()->sync($usercases);
            }
        }
    }
}
