<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user yang ada (kalau belum ada, bikin dulu)
        $users = User::where('role', 'member')->get();
        if ($users->count() < 5) {
            $this->command->error('⚠️ Minimal 5 member diperlukan. Jalankan UserSeeder dulu.');
            return;
        }

        $data = [
            // 4 data persis screenshot
            ['user_id' => $users[0]->id, 'total' => 50000, 'status' => 'success', 'created_at' => '2025-05-19 14:32:00'],
            ['user_id' => $users[1]->id, 'total' => 49000, 'status' => 'success', 'created_at' => '2025-05-19 14:15:00'],
            ['user_id' => $users[2]->id, 'total' => 35000, 'status' => 'success', 'created_at' => '2025-05-19 13:50:00'],
            ['user_id' => $users[3]->id, 'total' => 19000, 'status' => 'failed',  'created_at' => '2025-05-19 12:20:00'],
            // 16 data tambahan biar total 20 (pagination 4/halaman = 5 halaman)
            ['user_id' => $users[4]->id, 'total' => 75000, 'status' => 'success', 'created_at' => '2025-05-18 10:00:00'],
            ['user_id' => $users[0]->id, 'total' => 40000, 'status' => 'success', 'created_at' => '2025-05-18 09:30:00'],
            ['user_id' => $users[1]->id, 'total' => 25000, 'status' => 'pending', 'created_at' => '2025-05-17 16:45:00'],
            ['user_id' => $users[2]->id, 'total' => 60000, 'status' => 'success', 'created_at' => '2025-05-17 14:20:00'],
            ['user_id' => $users[3]->id, 'total' => 15000, 'status' => 'failed',  'created_at' => '2025-05-16 11:10:00'],
            ['user_id' => $users[4]->id, 'total' => 85000, 'status' => 'success', 'created_at' => '2025-05-16 09:00:00'],
            ['user_id' => $users[0]->id, 'total' => 30000, 'status' => 'success', 'created_at' => '2025-05-15 15:30:00'],
            ['user_id' => $users[1]->id, 'total' => 45000, 'status' => 'success', 'created_at' => '2025-05-15 13:00:00'],
            ['user_id' => $users[2]->id, 'total' => 20000, 'status' => 'pending', 'created_at' => '2025-05-14 10:45:00'],
            ['user_id' => $users[3]->id, 'total' => 55000, 'status' => 'success', 'created_at' => '2025-05-14 08:20:00'],
            ['user_id' => $users[4]->id, 'total' => 35000, 'status' => 'success', 'created_at' => '2025-05-13 16:00:00'],
            ['user_id' => $users[0]->id, 'total' => 70000, 'status' => 'success', 'created_at' => '2025-05-13 14:30:00'],
            ['user_id' => $users[1]->id, 'total' => 25000, 'status' => 'failed',  'created_at' => '2025-05-12 11:15:00'],
            ['user_id' => $users[2]->id, 'total' => 40000, 'status' => 'success', 'created_at' => '2025-05-12 09:00:00'],
            ['user_id' => $users[3]->id, 'total' => 60000, 'status' => 'success', 'created_at' => '2025-05-11 15:45:00'],
            ['user_id' => $users[4]->id, 'total' => 19000, 'status' => 'success', 'created_at' => '2025-05-11 13:20:00'],
        ];

        foreach ($data as $item) {
            Transaction::create($item);
        }

        $this->command->info('✅ 20 transaksi dummy ter-seed!');
    }}