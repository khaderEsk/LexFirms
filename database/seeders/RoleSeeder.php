<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'superAdmin']); //Fadi AND Hande
        $admin = Role::create(['name' => 'admin']); // Walaa
        $adminLawyer = Role::create(['name' => 'adminLawyer']); //Wd
        $lawyer = Role::create(['name' => 'lawyer']); //Lawyers
        $accounting = Role::create(['name' => 'accounting']); //Lawyers
        User::insert([
            'userName' => 'fadi',
            'email' => 'fadi@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        User::insert([
            'userName' => 'hande',
            'email' => 'hande@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        User::insert([
            'userName' => 'walaa',
            'email' => 'walaa@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        User::insert([
            'userName' => 'wid',
            'email' => 'wid@gmail.com',
            'password' => Hash::make('1234'),
        ]);
        User::insert([
            'userName' => 'samar',
            'email' => 'samar.accounting@gmail.com',
            'password' => Hash::make('1234'),
        ]);

        $fadi = User::find(1);
        $fadi->assignRole('superAdmin');

        $hande = User::find(2);
        $hande->assignRole('superAdmin');

        $walaa = User::find(3);
        $walaa->assignRole('admin');

        $wid = User::find(4);
        $wid->assignRole('adminLawyer');
        
        $samar = User::find(5);
        $samar->assignRole('accounting');
    }
}
