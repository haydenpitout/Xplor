<?php

namespace App\Support;

class RobotSimulator
{
    /**
     * Valid min, max X and Y axes for the application.
     *
     * @var array
     */    
    protected $validAxes = [0, 1, 2, 3, 4];

    /**
     * Valid directions for the application.
     *
     * @var array
     */    
    protected $validDirections = ['NORTH', 'SOUTH', 'EAST', 'WEST'];

    /**
     * Place the robot on the table in position X, Y and facing DIRECTION.
     *
     * @return bool
     */    
    public function place($x, $y, $direction): bool
    {
        if ( in_array($x, $this->validAxes, true) 
            && in_array($y, $this->validAxes, true) 
            && in_array($direction, $this->validDirections, true)) {
            
            // 1. Delete all historic robot movements
            // 2. Write given robot position and begin new game

            return true;
        }

        return false;
    }
    
    public function move($spaces = 1): bool
    {
        // 1. Read robots current position and direction
        // 2. Check if we can move the robot $spaces spaces in the facing direction
        // 3. If we can, write new robot position, return true
        // 4. If we can't return false
    }

    public function left(): bool
    {
        // 1. Read robots current position and direction
        // 2. Determine robots new direction
        // 3. Write new robot direction, return true
    }

    public function right(): bool
    {
        // 1. Read robots current position and direction
        // 2. Determine robots new direction
        // 3. Write new robot direction, return true
    }

    /**
     * Announce the X,Y and facing DIRECTION of the robot.
     *
     * @return array
     */     
    public function announce(): array
    {
        // 1. Read robots current position and direction
        // 2. Return robots current position and direction
    }



}