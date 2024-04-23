<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\elementType;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //array of categories / subCategories / childCategories
        $categories = [
            'Actualités' => [
                'Politique',
                'Économie',
                'Sport',
            ],
            'Divertissement' => [
                'Cinéma',
                'Musique',
                'Sorties',
            ],
            'Technologie' => [
                'Informatique' => [
                    'Ordinateurs de bureau',
                    'PC portable',
                    'Connexion internet',
                ],
                'Gadgets' => [
                    'Smartphones',
                    'Tablettes',
                    'Jeux vidéo',
                ],
            ],
            'Santé' => [
                'Médecine',
                'Bien-être',
            ],
        ];


        // iterate categories and insert data
        foreach ($categories as $category => $subCategories) {

            $categoryId = DB::table('categories')->insertGetId([ // category parent
                'nom' => $category,
            ]);

            foreach ($subCategories as $subCategory => $childCategories) { // subCategories

                if (is_array($childCategories)) { // check subCategories has childrens

                    $subCategoryId = DB::table('categories')->insertGetId([
                        'nom' => $subCategory,
                        'parent_id' => $categoryId
                    ]);

                    foreach ($childCategories as $childCategory) { // childCategories

                        DB::table('categories')->insert([
                            'nom' => $childCategory,
                            'parent_id' => $subCategoryId
                        ]);
                    }
                } else {

                    // insert subCategories when not has any children
                    DB::table('categories')->insert([
                        'nom' => $childCategories,
                        'parent_id' => $categoryId
                    ]);
                }
            }
        }
    }
}
