<?php

use Illuminate\Database\Seeder;

class KladrSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = \App\Models\Kladr\Country::create(['name' => 'Россия']);

        $seeder = resource_path('seeds/geo_coder.json');
        if (file_exists($seeder)) {
            $seeder = json_decode(file_get_contents($seeder), true);

            foreach ($seeder as $region_name => $cities_list) {
                $region = $country->regions()->create(['name' => $region_name]);

                foreach ($cities_list as $city_name => $geo) {
                    $pos = 0;
                    if ($city_name == 'Москва') $pos = 99999;

                    $city = $region->cities()->create([
                        'name' => $city_name,
                        'federal' => 0,
                        'geo_lat' => substr($geo['position']['lat'], 0, 8),
                        'geo_lon' => substr($geo['position']['lon'], 0, 9),
                        'pos' => $pos,
                    ]);

                    foreach ($geo['ip_list'] as $range) {
                        $city->georange()->create([
                            'ip_from' => $range['from'],
                            'ip_to' => $range['to'],
                        ]);
                    }
                }
            }
        }
    }
}
