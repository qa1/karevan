<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	foreach([
    		'ورود اطلاعات',
    		'مدیریت اسامی شهر ها',
    		'مدیریت اسامی مدیران کاروان ها',
    		'مدیریت کاربران',
    		'سطوح دسترسی',
    		'مدیریت زائرین',
    		'ثبت نام زائر',
    		'جستجوی زائر',
    		'ثبت تردد زائر',
    		'تهیه عکس زائر',
    		'ارتباط زائر با کد تردد',
    		'گزارشات',
    		'مدیریت پیام ها',
            'مسدود کردن کاروان',
            'خروجی زائرین'
    	] as $name) {
    		\Spatie\Permission\Models\Permission::create(compact('name'));
    	}
    }
}
