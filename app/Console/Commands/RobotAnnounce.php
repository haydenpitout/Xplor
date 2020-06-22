<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Xplor\RobotSimulator; 

class RobotAnnounce extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:announce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display the robots current position on the table';

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
        $simulator = new RobotSimulator();
        $result = $simulator->announce();

        if ($result['error'] === false) {
            $this->info('The current robots position is:');
            $this->table(['x', 'y', 'direction'], [$result['data']]);           
        }
        else {
            $this->error('Okay, Houston, we\'ve had a problem here.');
            $this->error($result['message']);
        }
    }
}
