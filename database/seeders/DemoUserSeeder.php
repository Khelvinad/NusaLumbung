<?php

namespace Database\Seeders;

use App\Models\PembeliProfile;
use App\Models\PetaniProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    /**
     * Demo accounts for local/testing (password: password).
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@nusalumbung.test'],
            [
                'name' => 'Budi Administrator',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $admin->syncRoles(['admin']);

        $petani = User::updateOrCreate(
            ['email' => 'petani@nusalumbung.test'],
            [
                'name' => 'Siti Rahayu',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $petani->syncRoles(['petani']);
        PetaniProfile::updateOrCreate(
            ['user_id' => $petani->id],
            [
                'no_telp' => '081234567801',
                'farm_name' => 'Kebun Siti Rahayu',
                'location' => 'Wonosobo, Jawa Tengah',
                'bio' => 'Petani padi organik dengan pengalaman 12 tahun. Fokus pada beras merah dan gabah berkualitas.',
                'rating_avg' => 4.75,
            ],
        );


        $pembeli = User::updateOrCreate(
            ['email' => 'pembeli@nusalumbung.test'],
            [
                'name' => 'Andi Wijaya',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );
        $pembeli->syncRoles(['pembeli']);
        PembeliProfile::updateOrCreate(
            ['user_id' => $pembeli->id],
            [
                'no_telp' => '081234567802',
                'address' => 'Jl. Melati No. 8, Tebet, Jakarta Selatan, DKI Jakarta 12820',
            ],
        );
    }
}
