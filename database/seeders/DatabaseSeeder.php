<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'       => 'admin',
            'first_name' => '名前',
            'last_name'  => '管理者',
            'password'   => '$2y$12$Kq2iUleSbV3iDz.xEGC74eYflVvJh4siDxJDdkGZOGKEoFea0.BA.', //"firsttime"
            'type'       => 1
        ]);
    }
}
