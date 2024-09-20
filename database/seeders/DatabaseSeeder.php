<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\About;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'role'=>'customer',
            'image'=>'https://cdn2.iconfinder.com/data/icons/people-groups/512/Man_Woman_Avatar-512.png',
        ]);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
            'role'=>'admin',
            'image'=>'https://cdn2.iconfinder.com/data/icons/people-groups/512/Man_Woman_Avatar-512.png',
        ]);

        Category::factory()->create([
            'name' => 'Poem',
            
        ]);

        Category::factory()->create([
            'name' => 'Story',
           
        ]);

        Category::factory()->create([
            'name' => 'Novel',
            
        ]);

        Category::factory()->create([
            'name' => 'It Related Book',
            
        ]);

         Category::factory()->create([
            'name' => 'Other',
            
        ]);

        
 $dummyImagePath = 'images/dummy-image.jpg'; // Ensure this image exists in the storage folder

        // Create 20 dummy records
        foreach (range(1, 20) as $index) {
            About::create([
                'title' => 'Title ' . $index,
                'slogan' => 'Slogan ' . $index,
                'description' => 'Description for entry ' . $index,
                'image' => $dummyImagePath, // Replace with actual image path if available
                'others' => 'Additional information ' . $index,
            ]);
        }
  



    }
}