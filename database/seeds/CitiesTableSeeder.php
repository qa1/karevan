<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach(['مشهد', 'تبریز', 'تهران', 'شیراز', 'قم', 'اصفهان', 'فیروزه'] as $name) {
    		\App\Models\City::create(compact('name'));
    	}
    }
}
