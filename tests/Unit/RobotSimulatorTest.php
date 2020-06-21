<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Support\RobotSimulator; 

class RobotSimulatorTest extends TestCase
{
    /**
     * Test valid X placements.
     *
     * @return void
     */
    public function testValidAxisPlacement()
    {
        $validX = [0, 1, 2, 3, 4];
        $validY = [0, 1, 2, 3, 4];
        $validXY = ['00', '01', '20', '34', '44'];

        $simulator = new RobotSimulator();

        foreach ($validX as $x) {
            $this->assertTrue( $simulator->place($x, 1, 'NORTH'));
        }

        foreach ($validY as $y) {
            $this->assertTrue( $simulator->place(1, $y, 'NORTH'));
        }

        foreach ($validXY as $coordinate) {
            $this->assertTrue( $simulator->place( (int) $coordinate[0], (int) $coordinate[1], 'NORTH'));
        } 
    }
}
