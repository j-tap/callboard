<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $seeder = resource_path('seeds/category.json');
        if (file_exists($seeder)) {
            $seeder = json_decode(file_get_contents($seeder), true);

            foreach ($seeder as $cat) {
                $category = \App\Models\Category::create([
                    'name' => $cat['name'],
                    'cl_icon'=>$cat['icon'],
                    'cl_background'=>$cat['color']]);

                if (!empty($cat['items']))
                    $this->createSubCategory($category, $cat['items']);
            }
        }
    }

    private function createSubCategory(\App\Models\Category $category, $items) {
        foreach ($items as $item) {
            $subcategory = $category->children()->create(['name' => $item['name']]);
            if (!empty($item['items'])) {
                $this->createSubCategory($subcategory, $item['items']);
            }
        }
    }
}
