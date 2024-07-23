<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register admin user to database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Loop until valid input is given
        do {
            $credentials = [
                'name' => $this->ask('Nama'),
                'username' => $this->ask('Username'), // Menggunakan username
                'address' => $this->ask('Alamat'),
                'telephone' => $this->ask('Nomor Telepon'),
                'gender' => $this->choice(
                    'Jenis Kelamin',
                    array_values(User::GENDERS), // Pilih dari konstanta yang ada
                ),
                'password' => $this->secret('Password'),
                'role' => User::ROLES['Admin'], // Role Admin dari konstanta
            ];

            // Validasi input
            $validator = Validator::make($credentials, [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username', // Validasi unik untuk username
                'address' => 'required|string|max:255',
                'telephone' => 'required|string|max:15', // Atau gunakan 'numeric'
                'gender' => 'required|string|in:Laki-laki,Perempuan',
                'password' => 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                // Tampilkan pesan error jika validasi gagal
                $this->error('Input tidak valid. Silakan coba lagi.');
                $this->info(implode("\n", $validator->errors()->all()));
            }
        } while ($validator->fails());

        // Simpan password asli untuk output
        $plainPassword = $credentials['password'];

        // Enkripsi password
        $credentials['password'] = Hash::make($plainPassword);

        // Buat pengguna baru
        $user = User::create($credentials);

        // Tampilkan tabel dengan username dan password asli
        $this->info('Pengguna Admin berhasil terdaftar:');
        $this->table(
            ['Username', 'Password'],
            [[$user->username, $plainPassword]]
        );

        return Command::SUCCESS;
    }
}

