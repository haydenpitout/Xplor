<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Xplor\RobotSimulator; 

class RobotLeft extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'robot:left';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Turn the robot left';

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
        $result = $simulator->left();

        if ($result['error'] === false) {
            $this->info('Houston, we are now facing '.$result['data']['direction'].' and ready to go.');
        }
        else {
            $this->error('Okay, Houston, we\'ve had a problem here.');
            $this->error($result['message']);
        }
    }
}
