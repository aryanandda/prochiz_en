<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

use App\Models\Admin;
use App\Models\User;
use App\Models\Article;
use App\Models\Event;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Models\RecipeDirection;
use App\Models\RecipeIngredient;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $storage_path = '/app/public/img/';

        //Create Admin
        $admin = new Admin;
        $admin->name = 'Administrator';
        $admin->email = 'admin@pentacode.id';
        $admin->password = Hash::make('ok');
        $admin->save();

        for ($i=0; $i < 20; $i++) { 
            $admin = new Admin;
            $admin->name = strtolower($faker->firstName);
            $admin->email = $admin->name.'_'.rand(10,99).'@pentacode.id';
            $admin->password = Hash::make('ok');
            $admin->save();
        }

        echo "Admin Created\n";

        //Create Users
        for ($i=0; $i < 5; $i++) { 
            $user = new User;
            $user->name = strtolower($faker->name);
            $user->email = $user->name.'_'.rand(10,99).'@pentacode.id';
            $user->password = Hash::make('ok');
            $user->save();
        }
        echo "Users Created\n";

        $arcticle_type = ['news', 'tips', 'video'];

        for ($i=0; $i < 40; $i++) { 
            $article = new Article;
            $article->admin_id = Admin::first()->id;
            $article->title = $faker->sentence(6);
            $article->slug = str_replace(" ", "-", $article->title);

            $article->type = $arcticle_type[rand(0,2)];

            $article->metadesc = $faker->sentence(36);
            $article->content = $faker->realText(300);
            $article->status = "published";
            $article->published_at = date("Y-m-d", strtotime("-".$i." days"));

            if ($article->type == 'video') {
                $article->video = '<iframe width="1280" height="720" src="https://www.youtube.com/embed/Ft97bSfS7x8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>';
            }
            
            $filename = rand(1000,9999).'_'.rand(1000,9999).'_'.rand(1000,9999).'.jpg';
            $im = imagecreate(1920, 600);
            $bg = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

            Image::make($im)->save(storage_path($storage_path.'/'.$filename));
            Image::make($im)->fit(600,600)->save(storage_path($storage_path.'/square/'.$filename));
            Image::make($im)->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$filename));

            $article->image = $filename;
            $article->save();
            
        }

        echo "News Created\n";
        echo "Tips Created\n";
        echo "Video Created\n";

        $event = new Event;
        $event->name = $faker->sentence(2);
        $event->slug = str_replace(" ", "-", $event->name);
        $event->metadesc = $faker->sentence(36);
        $event->description = $faker->realText(300);
        $event->status = "published";
        $event->start_at = date("Y-m-d");
        $event->end_at = date("Y-m-d", strtotime("+30 days"));
        
        $filename = rand(1000,9999).'_'.rand(1000,9999).'_'.rand(1000,9999).'.jpg';
        $im = imagecreate(1920, 600);
        $bg = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

        Image::make($im)->save(storage_path($storage_path.'/'.$filename));
        Image::make($im)->fit(200,200)->save(storage_path($storage_path.'/square/'.$filename));
        Image::make($im)->resize(100, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(storage_path($storage_path.'/small/'.$filename));

        $event->image = $filename;
        $event->save();

        echo "Event Created\n";

        $products = ['Prochiz Cheddar', 'Prochiz Gold', 'Prochiz Slices', 'Prochiz Spready', 'Prochiz Mayo'];
        foreach ($products as $value) { 
            $product = new Product;
            $product->name = $value;
            $product->slug = strtolower(str_replace(' ', '-', $value));
            $product->tagline = $faker->sentence(3);
            $product->metadesc = $faker->sentence(36);
            $product->description = $faker->realText(300);
            $product->ingredients = $faker->realText(300);
            $product->characteristics = $faker->realText(50);
            $product->size = '170 gr, 2 kg';
            $product->storage = $faker->realText(50);
            $product->status = "published";

            $filename = rand(1000,9999).'_'.rand(1000,9999).'_'.rand(1000,9999).'.jpg';
            $im = imagecreate(480, 320);
            $bg = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

            Image::make($im)->save(storage_path($storage_path.'/'.$filename));
            Image::make($im)->fit(200,200)->save(storage_path($storage_path.'/square/'.$filename));
            Image::make($im)->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$filename));

            $product->image = $filename;

            $product->save();
        }

        echo "Products Created\n";

        $recipe_categories = ['Sarapan', 'Makan Siang', 'Makan Malam', 'Snack'];
        foreach ($recipe_categories as $value) { 
            $recipe_category = new RecipeCategory;
            $recipe_category->name = $value;
            $recipe_category->slug = strtolower(str_replace(' ', '-', $value));
            $recipe_category->save();
        }

        for ($i=0; $i < 50; $i++) {
            $recipe = new Recipe;
            $recipe->name = $faker->sentence(6);
            $recipe->slug = str_replace(" ", "-", $recipe->name);
            $recipe->user_id = mt_rand(1, 5);
            $recipe->event_id = 1;
            $recipe->recipe_category_id = mt_rand(1, 4);

            $recipe_types = ['prochiz', 'prochizlover'];
            $recipe->type = $recipe_types[mt_rand(0, 1)];

            $recipe->metadesc = $faker->sentence(36);
            $recipe->description = $faker->realText(300);

            $recipe->published_at = date("Y-m-d", strtotime("-".$i." days"));
            
            $filename = rand(1000,9999).'_'.rand(1000,9999).'_'.rand(1000,9999).'.jpg';

            if($recipe->type=='prochiz') {
                $recipe->status = "published";
                $recipe->time = "30";
                $recipe->servings = "2";
                $im = imagecreate(1920, 600);
            }
            else {
                $recipe->status = "approved";
                $im = imagecreate(700, 700);
            }

            $bg = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

            Image::make($im)->save(storage_path($storage_path.'/'.$filename));
            Image::make($im)->fit(500,500)->save(storage_path($storage_path.'/square/'.$filename));
            Image::make($im)->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$filename));

            $recipe->image = $filename;
            $recipe->save();

            $directions = [];
            for ($j=0; $j < mt_rand(3, 7); $j++) { 
                $directions[] = new RecipeDirection(['name' => $faker->sentence(6)]);
            }

            $ingredients = [];
            for ($j=0; $j < mt_rand(3, 7); $j++) { 
                $amounts = ['1 sdm', '10 gram', '1 gram'];
                $ingredients[] = new RecipeIngredient(['name' => $faker->sentence(3), 'amount' => $amounts[mt_rand(0, 2)]]);
            }

            $recipe->directions()->saveMany($directions);
            $recipe->ingredients()->saveMany($ingredients);

            $products = range(mt_rand(1,4), mt_rand(2,5));
            $recipe->products()->sync($products);
        }

        echo "Recipe Created\n";
    }
}
