<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id'         => 1,
            'email'      => 'test@admin.com',
            'full_name'  => 'Test Admin',
            'password'   => bcrypt('test123'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('activations')->insert([
            'user_id'    => 1,
            'code'       => 'testcode',
            'completed'  => 1,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('roles')->insert([
        [
            'id'         => 1,
            'slug'       => 'admin',
            'name'       => 'Admin',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],
        [
            'id'         => 2,
            'slug'       => 'technician',
            'name'       => 'Technician',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ],
        [
            'id'         => 3,
            'slug'       => 'support',
            'name'       => 'Support',
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]]);

        DB::table('role_users')->insert([
            'user_id'    => 1,
            'role_id'    => 1,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
