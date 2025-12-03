<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartisipanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check which users exist and create data only for them
        $users = \App\Models\User::where('role', 'participant')->pluck('user_id')->toArray();
        
        if (empty($users)) {
            return; // No participant users, skip
        }

        $data = [];
        $subLombas = [1, 2, 3];
        $statuses = ['pending', 'approved', 'rejected', 'submitted'];
        $institutions = ['University A', 'Institute B', 'Highschool C', 'University D', 'University E', 
                        'Institute F', 'University G', 'Akademi H', 'University I', 'University J',
                        'Highschool K', 'College L', 'University M', 'Institute N', 'University O',
                        'University P', 'Institute Q', 'University R', 'College S', 'University T',
                        'Akademi U', 'University V', 'Institute W', 'University X', 'Highschool Y',
                        'University Z', 'College AA', 'University BB'];

        foreach ($users as $index => $userId) {
            // Skip users that already have entries
            $existingCount = \DB::table('partisipans')->where('user_id', $userId)->count();
            if ($existingCount >= 2) continue;

            for ($i = 0; $i < 2; $i++) {
                $sublombaId = $subLombas[$i % 3];
                $status = $statuses[$index % 4];
                $institution = $institutions[$index % count($institutions)];
                
                // Check if this combination exists
                $exists = \DB::table('partisipans')
                    ->where('user_id', $userId)
                    ->where('sublomba_id', $sublombaId)
                    ->exists();

                if (!$exists) {
                    $data[] = [
                        'user_id' => $userId,
                        'sublomba_id' => $sublombaId,
                        'institusi' => $institution,
                        'kontak' => '08' . rand(1000000000, 9999999999),
                        'file_karya' => null,
                        'status' => $status,
                        'registered_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($data)) {
            \DB::table('partisipans')->insert($data);
        }
    }
}
