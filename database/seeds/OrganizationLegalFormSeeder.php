<?php

use Illuminate\Database\Seeder;

class OrganizationLegalFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Org\OrganizationLegalForm::create(['name' => 'Общество с ограниченной ответственностью', 'short_name' => 'ООО']);
        \App\Models\Org\OrganizationLegalForm::create(['name' => 'Открытое акционерное общество', 'short_name' => 'ОАО']);
        \App\Models\Org\OrganizationLegalForm::create(['name' => 'Индивидуальный предпрениматель', 'short_name' => 'ИП']);
    }
}
