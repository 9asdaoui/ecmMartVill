<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Nwidart\Modules\Facades\Module;

class Seed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--seed=all} {--migrate=true}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        if ($this->option('migrate')) {
            try {
                $this->info('Migrating using schema...');
                $this->call('migrate:fresh', ['--schema-path' => database_path('schema/martvill-schema.sql')]);
                $this->info('Migration using schema successful.');
            } catch (\Exception $e) {
                $this->warn('Schema migration failed. Falling back to migration files...');
                $this->call('migrate:fresh');
                $this->info('Migration using migration files successful.');
            }
        }

        $this->mainAppSeed();
        if (! file_exists('Modules/Dummy/Database/Seeders/DummyImportDatabaseSeeder.php')) {
            $this->moduleSeed();
        } else {
            $this->copyImages();
        }

        $this->info('Database seeding completed successfully.');

        $this->warn('Copying seed files...');

        // Generate passport Client ID and secret
        $this->call('passport:install', ['--force' => true]);

        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('route:clear');
    }

    /*
    * Main App Seed
    *
    * @return void
    */
    protected function mainAppSeed()
    {
        $this->call('db:seed');
    }

    /*
    * Module Seed
    *
    * @return void
    */
    protected function moduleSeed()
    {
        $this->warn('Module Seeding: ');

        $this->modulesName()->each(function ($module) {
            Artisan::call('module:seed ' . $module);
            $this->line('   ✔ ' . $module);
        });

        $this->info('Module seeding completed successfully.');
    }

    /*
    * Modules Name
    *
    * @return array
    */
    protected function modulesName()
    {
        if ($this->option('seed') !== 'all') {
            return explode(',', $this->option('seed'));
        }

        return collect(Module::getOrdered())
            ->map(fn ($module) => $module->getName())
            ->values();
    }

    /**
     * Copies images from the module path to the public uploads directory.
     *
     * @return void
     */
    private function copyImages()
    {
        \File::copyDirectory(module_path('Dummy', 'Resources/assets/seeder/'), public_path('uploads/'));
    }
}
