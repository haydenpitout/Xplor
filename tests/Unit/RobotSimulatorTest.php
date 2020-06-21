<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Support\RobotSimulator; 

class RobotSimulatorTest extends TestCase
{
    /**
     * Test valid X, Y placements.
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

    /**
     * Test invalid X, Y placements.
     *
     * @return void
     */
    public function testInvalidAxisPlacement()
    {
        $invalidX = [0.1, -1, 5, '1', null, true, false];
        $invalidY = [1.0, -3, 99, '4', null, true, false];
        $invalidXY = [[0, 5], [true, true], ['1', 0], [1.0, 4], [true, false], [null, false]];

        $simulator = new RobotSimulator();

        foreach ($invalidX as $x) {
            $this->assertFalse( $simulator->place($x, 1, 'NORTH'));
        }

        foreach ($invalidY as $y) {
            $this->assertFalse( $simulator->place(1, $y, 'NORTH'));
        }

        foreach ($invalidXY as $coordinate) {
            $this->assertFalse( $simulator->place( $coordinate[0], $coordinate[1], 'NORTH'));
        } 
    }
    
    /**
     * Test direction placements.
     *
     * @return void
     */
    public function testDirectionPlacement()
    {
        $valid = ['NORTH', 'SOUTH', 'EAST', 'WEST'];
        $invalid = [null, true, false, 'north', ' NORTH', 'WEST '];

        $simulator = new RobotSimulator();

        foreach ($valid as $direction) {
            $this->assertTrue( $simulator->place(1, 1, $direction));
        }

        foreach ($invalid as $direction) {
            $this->assertFalse( $simulator->place(1, 1, $direction));
        }
    }    
    
}
