<?php

namespace App\Xplor;

use League\Csv\Reader;
use League\Csv\Writer;
use Storage;

class RobotSimulator
{
    /**
     * Min and max X and Y axes/coordinates for the application.
     *
     * @var integer
     */
    protected $minX = 0;
    protected $maxX = 4;
    protected $minY = 0;
    protected $maxY = 4;

    /**
     * Valid directions for the application.
     *
     * @var array
     */
    protected $validDirections = ['NORTH', 'SOUTH', 'EAST', 'WEST'];

    /**
     * The path to the file where the robots movements are stored
     *
     * @var string
     */
    protected $path = '';

    /**
     * Initialise the class
     *
     * @return void
     */
    public function __construct()
    {
        if (!Storage::disk('xplor')->exists('movements.csv')) {
            Storage::disk('xplor')->put('movements.csv', null);
        }

        $this->storagePath = Storage::disk('xplor')->path('movements.csv');
    }

// remove me

    /**
     * Place the robot on the table in position X, Y and facing DIRECTION.
     *
     * @return array
     */
    public function place($x, $y, $direction): array
    {
        try {

            if ((is_int($x) && $x >= $this->minX && $x <= $this->maxX)
                && (is_int($y) && $y >= $this->minY && $y <= $this->maxY)
                && in_array($direction, $this->validDirections, true)) {

                $this->recordReset([
                    $x,
                    $y,
                    $direction,
                ]);

                return $this->success(
                    $this->currentLocation()
                );
            }

            return $this->error(
                __('xplor.invalid_placement')
            );
        } catch (\Exception $e) {

            report($e);
            
            return $this->error(
                __('xplor.xplor_error')
            );
        }
    }

    /**
     * Move the robot the given number of space forward in the direction it is facing
     *
     * @return array
     */
    public function move($spaces = 1): array
    {
        try {

            $position = $this->currentLocation();

            if (!empty($position)) {

                switch ($position['direction']) {

                    case 'NORTH':

                        $newY = $position['y'] + $spaces;

                        if ($newY <= $this->maxY) {
                            $position['y'] = $newY;
                            $this->recordMovement($position);
                            return $this->success(
                                $this->currentLocation()
                            );
                        } else {
                            return $this->error(
                                __('xplor.fall_off_table', ['direction' => 'Northern'])
                            );
                        }

                        break;

                    case 'SOUTH':

                        $newY = $position['y'] - $spaces;

                        if ($newY >= $this->minY) {
                            $position['y'] = $newY;
                            $this->recordMovement($position);
                            return $this->success(
                                $this->currentLocation()
                            );
                        } else {
                            return $this->error(
                                __('xplor.fall_off_table', ['direction' => 'Southern'])
                            );
                        }

                        break;

                    case 'EAST':

                        $newX = $position['x'] + $spaces;

                        if ($newX <= $this->maxX) {
                            $position['x'] = $newX;
                            $this->recordMovement($position);
                            return $this->success(
                                $this->currentLocation()
                            );
                        } else {
                            return $this->error(
                                __('xplor.fall_off_table', ['direction' => 'Eastern'])
                            );
                        }

                        break;

                    case 'WEST':

                        $newX = $position['x'] - $spaces;

                        if ($newX >= $this->minX) {
                            $position['x'] = $newX;
                            $this->recordMovement($position);
                            return $this->success(
                                $this->currentLocation()
                            );
                        } else {
                            return $this->error(
                                __('xplor.fall_off_table', ['direction' => 'Western'])
                            );
                        }

                        break;
                }
            }

            return $this->error(
                __('xplor.not_on_table')
            );
        } catch (\Exception $e) {

            report($e);

            return $this->error(
                __('xplor.xplor_error')
            );
        }
    }

    /**
     * Turn the robot left
     *
     * @return array
     */
    public function left(): array
    {
        try {

            $position = $this->currentLocation();

            if (!empty($position)) {

                switch ($position['direction']) {

                    case 'NORTH':
                        $position['direction'] = 'WEST';
                        break;

                    case 'SOUTH':
                        $position['direction'] = 'EAST';
                        break;

                    case 'EAST':
                        $position['direction'] = 'NORTH';
                        break;

                    case 'WEST':
                        $position['direction'] = 'SOUTH';
                        break;
                }

                $this->recordMovement($position);

                return $this->success(
                    $this->currentLocation()
                );
            }

            return $this->error(
                __('xplor.not_on_table')
            );
        } catch (\Exception $e) {

            report($e);

            return $this->error(
                __('xplor.xplor_error')
            );
        }
    }

    /**
     * Turn the robot right
     *
     * @return array
     */
    public function right(): array
    {
        try {

            $position = $this->currentLocation();

            if (!empty($position)) {

                switch ($position['direction']) {

                    case 'NORTH':
                        $position['direction'] = 'EAST';
                        break;

                    case 'SOUTH':
                        $position['direction'] = 'WEST';
                        break;

                    case 'EAST':
                        $position['direction'] = 'SOUTH';
                        break;

                    case 'WEST':
                        $position['direction'] = 'NORTH';
                        break;
                }

                $this->recordMovement($position);

                return $this->success(
                    $this->currentLocation()
                );
            }

            return $this->error(
                __('xplor.not_on_table')
            );
        } catch (\Exception $e) {

            report($e);

            return $this->error(
                __('xplor.xplor_error')
            );
        }
    }

    /**
     * Announce the X,Y and facing DIRECTION of the robot.
     *
     * @return array
     */
    public function announce(): array
    {
        try {

            $currentLocation = $this->currentLocation();

            if (!empty($currentLocation)) {
                return $this->success(
                    $currentLocation
                );
            }

            return $this->error(
                __('xplor.not_on_table')
            );
        } catch (\Exception $e) {

            report($e);

            return $this->error(
                __('xplor.xplor_error')
            );
        }
    }

    /**
     * Reset the robots coordinates to the given position
     *
     * @return array
     */
    private function recordReset(array $position): array
    {
        $writer = Writer::createFromPath($this->storagePath, 'w+');
        $writer->insertAll([['x', 'y', 'direction'], $position]);

        return $this->currentLocation();
    }

    /**
     * Record a robot movement change (x, y or direction)
     *
     * @return array
     */
    private function recordMovement(array $position): array
    {
        $writer = Writer::createFromPath($this->storagePath, 'a+');
        $writer->insertOne($position);

        return $this->currentLocation();
    }

    /**
     * Return the current location of the robot
     *
     * @return array
     */
    private function currentLocation(): array
    {
        $row = [];

        $reader = Reader::createFromPath($this->storagePath, 'r');
        if (count($reader) > 1) {
            $reader->setHeaderOffset(0);
            $row = $reader->fetchOne(count($reader) - 1);
        }

        return $row;
    }

    /**
     * Return a formatted success message
     *
     * @return array
     */
    private function success(array $data): array
    {
        return [
            'error' => false,
            'message' => null,
            'data' => $data,
        ];
    }

    /**
     * Return a formatted error message
     *
     * @return array
     */
    private function error(string $message): array
    {
        return [
            'error' => true,
            'message' => $message,
            'data' => [],
        ];
    }
}
