<?php

namespace App\Console\Commands;

use App\Models\Users\Admin;
use App\Models\MasterData\City;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin';

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
        Admin::updateOrCreate([
            'mobile' => '512345678',
        ], [
            'name' => 'admin',
            'mobile' => '512345678',
            'password' => bcrypt(123456),
            'city_id' => optional(City::first())->id,
        ]);

        $this->info('Mobile: 512345678');
        $this->info('Password: 123456');

        return 0;
    }
}
