<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::query()->where('email', 'admin@admin.com')->get()->first();
        if($user == null){
            $user = User::create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456789'),
                'status' => '1',
            ]);
        }
        $user->syncRoles(['administrator']);
    }
}
  