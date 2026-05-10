<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@restaurant.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $cats = [
            ['name' => 'Entrées', 'description' => 'Pour bien commencer', 'items' => [
                ['Salade César', 3500, true, 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400'],
                ['Soupe du jour', 2500, false, 'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=400'],
                ['Carpaccio', 4000, false, 'https://images.unsplash.com/photo-1559847844-5315695dadae?w=400'],
            ]],
            ['name' => 'Plats', 'description' => 'Nos spécialités', 'items' => [
                ['Poulet rôti', 7500, true, 'https://images.unsplash.com/photo-1527477396000-e27163b481c2?w=400'],
                ['Brochettes de bœuf', 8500, true, 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400'],
                ['Poisson grillé', 9000, false, 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=400'],
                ['Riz aux crevettes', 6500, false, 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=400'],
            ]],
            ['name' => 'Desserts', 'description' => 'La douceur en fin de repas', 'items' => [
                ['Fondant au chocolat', 2500, true, 'https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=400'],
                ['Crème brûlée', 2000, false, 'https://images.unsplash.com/photo-1470124182917-cc6e71b22ecc?w=400'],
                ['Salade de fruits', 1800, false, 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=400'],
            ]],
            ['name' => 'Boissons', 'description' => 'Fraîches et chaudes', 'items' => [
                ['Jus d\'ananas', 1000, false, 'https://images.unsplash.com/photo-1589733955941-5eeaf752f6dd?w=400'],
                ['Café', 500, false, 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400'],
                ['Eau minérale', 500, false, 'https://images.unsplash.com/photo-1548839140-29a749e1cf4d?w=400'],
            ]],
        ];

        foreach ($cats as $cat) {
            $category = Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'description' => $cat['description'],
                'is_active' => true,
            ]);

            foreach ($cat['items'] as [$name, $price, $featured, $image]) {
                MenuItem::create([
                    'category_id' => $category->id,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'price' => $price,
                    'image' => $image,
                    'is_available' => true,
                    'is_featured' => $featured,
                ]);
            }
        }
    }
}