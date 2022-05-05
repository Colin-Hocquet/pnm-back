<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        
        $listRoom = [[
            'label' => "cuisine",
            'default' => true, 
            'user_id' => 1,
        ],
        [
            'label' => "salle de bain",
            'default' => true,
            'user_id' => 1,
        ],
        [
            'label' => "chambre",
            'default' => true,
            'user_id' => 1,
        ],
        [
            'label' => "salon",
            'default' => true,
            'user_id' => 1,
        ]];
        foreach($listRoom as $room) {
            DB::table('inventories')->insert([
                'label' => $room['label'],
                'default' => $room['default'],
                'user_id' => $room['user_id'],
                ]);



        }
    }
}
