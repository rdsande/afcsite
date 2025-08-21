<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\District;

class TanzaniaLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regionsData = [
            'Arusha' => ['Arusha City', 'Arusha Rural', 'Karatu', 'Longido', 'Monduli', 'Ngorongoro'],
            'Dar es Salaam' => ['Ilala', 'Kinondoni', 'Temeke', 'Ubungo', 'Kigamboni'],
            'Dodoma' => ['Dodoma City', 'Bahi', 'Chamwino', 'Chemba', 'Kondoa', 'Kongwa', 'Mpwapwa'],
            'Geita' => ['Geita Town', 'Bukombe', 'Chato', 'Geita', 'Mbogwe', 'Nyang\'hwale'],
            'Iringa' => ['Iringa City', 'Iringa Rural', 'Kilolo', 'Mafinga', 'Mufindi'],
            'Kagera' => ['Bukoba', 'Biharamulo', 'Karagwe', 'Kyerwa', 'Misenyi', 'Muleba', 'Ngara'],
            'Katavi' => ['Mpanda', 'Mlele', 'Nsimbo'],
            'Kigoma' => ['Kigoma', 'Buhigwe', 'Kakonko', 'Kasulu', 'Kibondo', 'Uvinza'],
            'Kilimanjaro' => ['Moshi', 'Hai', 'Mwanga', 'Rombo', 'Same', 'Siha'],
            'Lindi' => ['Lindi', 'Kilifi', 'Liwale', 'Nachingwea', 'Ruangwa'],
            'Manyara' => ['Babati', 'Hanang', 'Kiteto', 'Mbulu', 'Simanjiro'],
            'Mara' => ['Musoma', 'Bunda', 'Butiama', 'Musoma Rural', 'Rorya', 'Serengeti', 'Tarime'],
            'Mbeya' => ['Mbeya City', 'Chunya', 'Kyela', 'Mbarali', 'Mbeya Rural', 'Momba', 'Rungwe'],
            'Morogoro' => ['Morogoro', 'Gairo', 'Kilombero', 'Kilosa', 'Mvomero', 'Ulanga'],
            'Mtwara' => ['Mtwara', 'Masasi', 'Mtwara Rural', 'Nanyumbu', 'Newala', 'Tandahimba'],
            'Mwanza' => ['Mwanza City', 'Ilemela', 'Kwimba', 'Magu', 'Misungwi', 'Nyamagana', 'Sengerema', 'Ukerewe'],
            'Njombe' => ['Njombe', 'Ludewa', 'Makambako', 'Makete', 'Njombe Rural', 'Wanging\'ombe'],
            'Pwani' => ['Kibaha', 'Bagamoyo', 'Chalinze', 'Kisarawe', 'Mafia', 'Mkuranga', 'Rufiji'],
            'Rukwa' => ['Sumbawanga', 'Kalambo', 'Nkasi', 'Sumbawanga Rural'],
            'Ruvuma' => ['Songea', 'Madaba', 'Mbinga', 'Namtumbo', 'Nyasa', 'Songea Rural', 'Tunduru'],
            'Shinyanga' => ['Shinyanga', 'Kahama', 'Kishapu', 'Maswa', 'Meatu', 'Msalala', 'Shinyanga Rural'],
            'Simiyu' => ['Bariadi', 'Busega', 'Itilima', 'Maswa', 'Meatu'],
            'Singida' => ['Singida', 'Ikungi', 'Manyoni', 'Mkalama', 'Singida Rural'],
            'Songwe' => ['Mbozi', 'Ileje', 'Momba', 'Songwe'],
            'Tabora' => ['Tabora', 'Igunga', 'Kaliua', 'Nzega', 'Sikonge', 'Tabora Rural', 'Urambo', 'Uyui'],
            'Tanga' => ['Tanga City', 'Handeni', 'Kilifi', 'Korogwe', 'Lushoto', 'Mkinga', 'Muheza', 'Pangani'],
            'Zanzibar North' => ['Kaskazini A', 'Kaskazini B'],
            'Zanzibar South' => ['Kusini', 'Mjini Magharibi'],
            'Pemba North' => ['Kaskazini Pemba'],
            'Pemba South' => ['Kusini Pemba']
        ];

        foreach ($regionsData as $regionName => $districts) {
            $region = Region::create(['name' => $regionName]);
            
            foreach ($districts as $districtName) {
                District::create([
                    'name' => $districtName,
                    'region_id' => $region->id
                ]);
            }
        }
    }
}
