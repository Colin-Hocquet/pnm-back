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
    public function run() {
        $this->call(UserSeeder::class);

        $listRoom = [
            [
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
            ]
        ];

        foreach($listRoom as $room) {
            DB::table('inventories')->insert([
                'label' => $room['label'],
                'default' => $room['default'],
                'user_id' => $room['user_id'],
            ]);
        }

        $vehicles = [
            [
                'label' => "Fourgonette",
                'description' => "Vous souhaitez déménager un très petit studio ou une chambre d’étudiant ? Cet utilitaire, facile à conduire et à garer, parfait pour déplacer des objets encombrants et des cartons de taille moyenne.",
                'image' => "../../../assets/images/fourgonette.png",
                'capacity' => "3/4m³"
            ],
            [
                'label' => "Camionette",
                'description' => "Voici l’utilitaire idéal pour meubler un studio par exemple. Canapé, lit, machine à laver, lave-vaisselle, buffet… trouveront place facilement à l’intérieur de cet utilitaire. Notez que ce véhicule de location est pratique à manœuvrer en ville.",
                'image' => "../../../assets/images/camionette.png",
                'capacity' => "5/6m³"
            ],
            [
                'label' => "Fourgon",
                'description' => "C’est le véhicule idéal pour déménager un grand appartement ou une maison comprenant 4 pièces. Cet utilitaire, avec sa capacité de stockage, transportera tous vos objets, cartons et meubles volumineux.",
                'image' => "../../../assets/images/fourgon.png",
                'capacity' => "13/14m³"
            ],
            [
                'label' => "Camion",
                'description' => "Un grand déménagement se profile ? Il s’agit du plus grand camion que l’on puisse conduire avec le permis B. Cet utilitaire dispose d’un important volume de stockage, idéal pour déménager en une seule fois des surfaces importantes comme une maison familiale. Meubles imposants, objets volumineux, gros cartons… tout se stocke sans soucis.",
                'image' => "../../../assets/images/camion.png",
                'capacity' => "20/30m³"
            ]
            ];

        foreach($vehicles as $vehicle) {
            DB::table('vehicles')->insert([
                'label' => $vehicle['label'],
                'description' => $vehicle['description'],
                'image' => $vehicle['image'],
                'capacity' => $vehicle['capacity'],
            ]);
        }
    }
}
