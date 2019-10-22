<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Minify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'minify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unused files to reduce output size';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vendorPath = base_path('/vendor');

        // Remove Formats From Vendors
        foreach (['*.sass', '*.scss', '*.css', '*.js', '*.less', '*.blade.php', '*.ttf', '*.afm', '*.ufm'] as $ext) {
            foreach (rglob($vendorPath . '/' . $ext) as $file) {
                unlink($file);
            }
        }

        // Some Vendor Folders
        foreach (rglob($vendorPath . '/Examples') as $folder) {
            @rrmdir($folder);
        }

        // Some Vendor Folders
        foreach (rglob($vendorPath . '/tests') as $folder) {
            @rrmdir($folder);
        }

        // Some Vendor Folders
        foreach (rglob($vendorPath . '/unitTests') as $folder) {
            @rrmdir($folder);
        }

        // Some Vendor Folders
        foreach (rglob($vendorPath . '/assets') as $folder) {
            @rrmdir($folder);
        }

        @rrmdir(public_path("$vendorPath/bin"));

        // Unlink Storage
        @unlink(public_path('storage'));

        // Remove Directory Importer
        @rrmdir(public_path('storage'));
        @mkdir(public_path('storage'));
        @mkdir(public_path('storage/public'));

        // Remove Assets
        @rrmdir(base_path('/resources/assets'));

        // remove database
        @unlink(database_path("database.sqlite"));
        @touch(database_path("database.sqlite"));

        // Remove Git
        // rrmdir(base_path('/.git'));
    }
}
