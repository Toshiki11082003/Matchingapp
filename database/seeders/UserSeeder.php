<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "遠藤駿樹",
            'email' => '22j5030@stu.meisei-u.ac.jp',
            'password' => Hash::make('Endou11082003'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}