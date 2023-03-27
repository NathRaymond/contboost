<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('tools')->get()->count() == 0) {
            $tools = [
                [
                    'display' => 0,
                    'slug' => "md5-generator",
                    'icon' => "art art-md5",
                    'class_name' => 'App\Tools\Md5Generator',
                    'en' => ['title' => 'MD5 Generator', 'name' => 'MD5 Generator', 'content' => 'Edit me from admin panel...']
                ],
            ];
            foreach ($tools as $data) {
                $tool = Tool::create($data);

                $tool->fill(['en' => $data['en']]);
                $tool->save();
            }
        }
    }
}
