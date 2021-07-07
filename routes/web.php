<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AuthController;
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




// start Admin panel Routes...
Route::get('/logout', function () {
    Session::forget('user');
    return redirect('/');
});

Route::get('/',[AuthController::class,'get_login']);
Route::post('/login',[AuthController::class,'Admin_login']);
Route::get('/index',[AdminController::class,'index']);
Route::get('/clubs',[AdminController::class,'get_clubs']);
Route::get('/add-club',[AdminController::class,'add_clubs']);
Route::post('/add-club',[AdminController::class,'Insert_clubs']);
Route::get('/delete_club/{id}',[AdminController::class,'Deleteclub']);

Route::get('/user',[AdminController::class,'get_user']);
Route::get('/add-user',[AdminController::class,'add_user']);
Route::post('/add-user',[AdminController::class,'Insert_user']);
Route::get('/delete_user/{id}',[AdminController::class,'Deleteuser']);

Route::get('/roles',[AdminController::class,'get_roles']);
Route::get('/add-roles',[AdminController::class,'add_roles']);
Route::post('/add-roles',[AdminController::class,'Insert_roles']);

Route::get('/ballrooms',[AdminController::class,'get_ballrooms']);
Route::get('/add-ballroom',[AdminController::class,'add_ballroom']);
Route::post('/add-ballroom',[AdminController::class,'Insert_ballroom']);
Route::get('/delete_ballroom/{id}',[AdminController::class,'Deleteballroom']);

Route::get('/materials',[AdminController::class,'get_material']);
Route::get('/add-material',[AdminController::class,'add_material']);
Route::post('/add-material',[AdminController::class,'Insert_material']);
Route::get('/delete_ballroom/{id}',[AdminController::class,'Deleteballroom']);
Route::get('/club-material',[AdminController::class,'club_material']);
Route::get('/addcmaterial',[AdminController::class,'get_cmaterial']);
Route::Post('/add-cmaterial',[AdminController::class,'Insert_cmaterial']);
Route::get('/delete_material/{id}',[AdminController::class,'DeleteMaterial']);