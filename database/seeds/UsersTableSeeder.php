<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
        	'name' => 'مدیر پایگاه',
        	'username' => 'admin',
        	'password' => \Hash::make('2060')
        ])->syncPermissions(\Spatie\Permission\Models\Permission::pluck('name'));

        \App\Models\User::create([
        	'name' => 'کاربر پایگاه',
        	'username' => 'karbar',
        	'password' => \Hash::make('2060')
        ])->syncPermissions([
        	'مدیریت اسامی شهر ها',
        	'مدیریت اسامی مدیران کاروان ها',
        	'مدیریت زائرین',
        	'ثبت نام زائر',
        	'جستجوی زائر',
    		'ثبت تردد زائر',
    		'تهیه عکس زائر',
    		'ارتباط زائر با کد تردد',
    		'گزارشات',
    		'مدیریت پیام ها',
            'مسدود کردن کاروان'
        ]);
    }
}
