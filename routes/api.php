<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('roles_list',[ApiController::class,'get_roles']);
Route::post('user_login',[ApiController::class,'Userlogin']);
Route::post('dashboard',[ApiController::class,'homePage']);
Route::post('material_list',[ApiController::class,'club_material']);
Route::post('add_material',[ApiController::class,'ballroom_item']);
Route::post('material_orders',[ApiController::class,'orders']);
Route::post('orders',[ApiController::class,'material_orders']);
Route::post('get_ballroom_details',[ApiController::class,'ballroom_details']);
Route::get('approved_list',[ApiController::class,'approve_List']);
Route::post('set_user_profile',[ApiController::class,'Get_profile']);
Route::post('get_user_details',[ApiController::class,'Get_user']);