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

use App\Support\RobotSimulator;

Route::get('/', function () {
    
    $simulator = new RobotSimulator();

    dd(
        $simulator->place(0, 1, 'NORTH')
    );
    
    //return view('welcome');
});
