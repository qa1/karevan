<?php

use Illuminate\Database\Seeder;

class ModirKarevanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['شریفی کاشمر', 'سفید سنگ فریمان', 'میرزایی', 'حمامی', 'نجاتی', 'محمد زاده تربت جام', 'نبی اله بحرودی', 'سید مجید باغداری'] as $name) {
    		\App\Models\Modirkarevan::create(compact('name'));
    	}
    }
}
