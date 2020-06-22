<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Xplor\RobotSimulator; 

class RobotPlace extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:place 
        {x : The x-axis coordinate to place the robot on} 
        {y : The y-axis coordinate to place the robot on} 
        {direction : The direction to face the robot}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Place the robot on the table to begin a new game';

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
        $x = $this->argument('x');
        $y = $this->argument('y');
        $direction = $this->argument('direction');

        $simulator = new RobotSimulator();
        $result = $simulator->place((int) $x, (int) $y, (string) $direction);

        if ($result['error'] === false) {
            $this->info('Houston, we are set and ready to go.');
        }
        else {
            $this->error('Okay, Houston, we\'ve had a problem here.');
            $this->error($result['message']);
        }
    }
}
