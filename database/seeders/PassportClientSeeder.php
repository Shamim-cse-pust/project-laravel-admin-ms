<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\ClientRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PassportClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientRepository = app(ClientRepository::class);

        $clientRepository->createPersonalAccessClient(
            null,
            'Laravel api',
            'http://localhost'
        );

        $this->command->info('Passport personal access client created successfully.');
    }
}
