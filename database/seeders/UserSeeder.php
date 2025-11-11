<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suerAdmin = User::create([
            'userName' => 'fadi',
            'email' => 'fadi@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        $suerAdmin->assignRole('superAdmin');
        
        $suerAdmin1 = User::create([
            'userName' => 'hande',
            'email' => 'hande@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        $suerAdmin1->assignRole('superAdmin');

        $admin = User::create([
            'userName' => 'walaa',
            'email' => 'walaa@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        $admin->assignRole('admin');

$majorRole = User::create([
            'userName' => 'od',
            'email' => 'od@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        
        $majorRole->assignRole('major');

$accountant = User::create([
            'userName' => 'hend',
            'email' => 'hend@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        
        $accountant->assignRole('accountant');
$lawyerRole = User::create([
            'userName' => 'ola',
            'email' => 'ola@gmail.com',
            'password' => Hash::make('12341234'),
        ]);
        
        $lawyerRole->assignRole('lawyer');

    }
}
