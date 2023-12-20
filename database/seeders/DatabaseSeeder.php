<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'merek']);
        Permission::create(['name' => 'mobil']);
        Permission::create(['name' => 'peminjaman']);
        Permission::create(['name' => 'pengembalian']);
        Permission::create(['name' => 'pengguna']);
        Permission::create(['name' => 'peran pengguna']);
        Permission::create(['name' => 'transaksi']);

        $roleDeveloper = Role::create(['name' => 'developer']);
        $roleDeveloper->syncPermissions(['peran pengguna', 'pengguna', 'merek', 'mobil', 'transaksi']);

        $rolePenyewa = Role::create(['name' => 'penyewa']);
        $rolePenyewa->syncPermissions(['dashboard', 'peminjaman', 'pengembalian']);

        $userDeveloper = User::factory()->create([
            'name' => 'Admin',
            'email' => 'a@mail.com',
            'password' => bcrypt('a')
        ]);
        $userDeveloper->assignRole($roleDeveloper);
        $userPenyewa = User::factory()->create([
            'name' => 'Penyewa',
            'email' => 'penyewa@mail.com',
            'password' => bcrypt('penyewa@mail.com')
        ]);
        $userPenyewa->assignRole($rolePenyewa);
    }
}
