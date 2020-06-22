<?php

namespace Tests\Unit;

use Storage;
use Tests\TestCase;
use App\Xplor\RobotSimulator;

class RobotSimulatorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('xplor');

        $this->simulator = new RobotSimulator();
    }

    public function tearDown(): void
    {
        Storage::fake('xplor')->delete('movements.csv');
        
        parent::tearDown();
    }    
    
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

        foreach ($validX as $x) {
            $this->assertFalse( $this->simulator->place($x, 1, 'NORTH')['error']);
        }

        foreach ($validY as $y) {
            $this->assertFalse( $this->simulator->place(1, $y, 'NORTH')['error']);
        }

        foreach ($validXY as $coordinate) {
            $this->assertFalse( $this->simulator->place( (int) $coordinate[0], (int) $coordinate[1], 'NORTH')['error']);
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

        foreach ($invalidX as $x) {
            $this->assertTrue( $this->simulator->place($x, 1, 'NORTH')['error']);
        }

        foreach ($invalidY as $y) {
            $this->assertTrue( $this->simulator->place(1, $y, 'NORTH')['error']);
        }

        foreach ($invalidXY as $coordinate) {
            $this->assertTrue( $this->simulator->place( $coordinate[0], $coordinate[1], 'NORTH')['error']);
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

        foreach ($valid as $direction) {
            $this->assertFalse( $this->simulator->place(1, 1, $direction)['error']);
        }

        foreach ($invalid as $direction) {
            $this->assertTrue( $this->simulator->place(1, 1, $direction)['error']);
        }
    }
}
