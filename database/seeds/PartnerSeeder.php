<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Models\PartnerGallery;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $storage_path = '/app/public/kuliner/';

        for ($i=0; $i < 12; $i++) {
            $category = new PartnerCategory;
            $category->name = $faker->text(20);
            $category->slug = str_replace(" ", "-", $category->name);
            $category->metadesc = $faker->text();
            $category->description = $faker->text(300);

            $filename = rand(1000,9999).'-'.rand(1000,9999).'-'.rand(1000,9999).'-category-'.uniqid().'.jpg';
            $im = imagecreate(500, 500);
            $bg = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

            Image::make($im)->save(storage_path($storage_path.'/'.$filename));
            Image::make($im)->fit(500,500)->save(storage_path($storage_path.'/square/'.$filename));
            Image::make($im)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$filename));

            $category->image = $filename;

            $category->save();
        }

        $status = ['pending', 'approved', 'rejected'];
        $count = PartnerCategory::count();
        for ($i=0; $i < 50; $i++) {
            $partner = new Partner;
            $partner->user_id = 1;
            $partner->name = $faker->text(50);
            $partner->slug = str_replace(" ", "-", $partner->name);
            $partner->metadesc = $faker->text();
            $partner->description = $faker->text(300);
            $partner->address = $faker->text(100);
            $partner->city = $faker->text(15);
            $partner->hours = $faker->text(15);
            $partner->phone = $faker->phoneNumber;
            $partner->email = $faker->email;
            $partner->website = $faker->url;
            $partner->facebook = 'https://www.facebook.com/'.$faker->userName;
            $partner->instagram = 'https://www.instagram.com/'.$faker->userName;
            $partner->status = $status[mt_rand(0, 2)];

            $filename = rand(1000,9999).'-'.rand(1000,9999).'-'.rand(1000,9999).'-'.uniqid().'.jpg';
            $im = imagecreate(500, 500);
            $bg = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

            Image::make($im)->save(storage_path($storage_path.'/'.$filename));
            Image::make($im)->fit(500,500)->save(storage_path($storage_path.'/square/'.$filename));
            Image::make($im)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(storage_path($storage_path.'/small/'.$filename));

            $partner->image = $filename;
            $partner->save();

            $categories = range(mt_rand(1,$count - 1), mt_rand(2,$count));
            $partner->categories()->sync($categories);

            for ($j=0; $j < mt_rand(2, 20); $j++) { 
                $gallery = new PartnerGallery;
                $gallery->partner_id = $partner->id;
                $gallery->name = $faker->text(10);
                $gallery->caption = $faker->text(100);

                $filename = rand(1000,9999).'-'.rand(1000,9999).'-'.rand(1000,9999).'-gallery-'.uniqid().'.jpg';
                $im = imagecreate(mt_rand(500, 1000), mt_rand(500, 1000));
                $bg = imagecolorallocate($im, rand(0,255), rand(0,255), rand(0,255));

                Image::make($im)->save(storage_path($storage_path.'/'.$filename));
                Image::make($im)->fit(300,300)->save(storage_path($storage_path.'/square/'.$filename));
                Image::make($im)->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(storage_path($storage_path.'/small/'.$filename));

                $gallery->image = $filename;
                $gallery->save();
            }
        }
    }
}