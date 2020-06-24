<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Xplor\RobotSimulator; 

class RobotMove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:move';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move the robot one space in the direction it is facing';

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
        $result = $simulator->move();

        if ($result['error'] === false) {
            $this->info('Houston, we have journeyed '.$result['data']['direction'].' one light year.');
        }
        else {
            $this->error('Okay, Houston, we\'ve had a problem here.');
            $this->error($result['message']);
        }
    }
}
