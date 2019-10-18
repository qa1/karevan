<?php

use Illuminate\Database\Seeder;

class TrafficsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach(\App\Models\Person::inRandomOrder()->get() as $person) {

    		if (mt_rand(1,3) == 1) {
    			if (!$person->isIn()) {
    				$person->enter();
    			} else {
    				$person->addError('ورود');
    			}
    		}

    		if (mt_rand(1,3) == 1) {
    			if ($person->isIn()) {
    				$person->leave();
    			} else {
    				$person->addError('خروج');
    			}
    		}

    	}
    }
}
