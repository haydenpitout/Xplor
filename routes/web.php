<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Xplor\RobotSimulator;

Route::get('/', function () {
    

    $simulator = new RobotSimulator();

    $simulator->place(0, 0, 'NORTH');
    $simulator->move();
    $simulator->move();
    $simulator->move();
    $simulator->move();
    $simulator->right();
    $simulator->move();
    $simulator->move();
    $simulator->right();
    $simulator->move();
    $simulator->left();
    $simulator->move();


    dd( $simulator->announce());
    
    //return view('welcome');
});
