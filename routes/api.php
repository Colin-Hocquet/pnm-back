<?php

use App\Http\Controllers\ItemBoxController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/loginAdmin', [AuthController::class, 'loginAdmin'])->name('loginAdmin');
Route::post('/password/forgot-password', [ForgotPasswordController::class, 'sendResetLinkResponse'])->name('passwords.sent');
Route::post('/password/reset', [ResetPasswordController::class, 'sendResetResponse'])->name('passwords.reset');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResources([
        'user' => UserController::class,
        'item' => ItemController::class,
        'inventory' => InventoryController::class,
        'box' => BoxController::class,
        'vehicle' => VehicleController::class,
        'itembox' => ItemBoxController::class,
        'settings' => SettingsController::class
    ]);
    Route::get('inventory/items/{id}', [ItemController::class,'findAllItemByInventory'])->name('inventory.findAllItemByInventory');
    Route::get('defaultInventory', [InventoryController::class,'findAllDefaultInventories'])->name('inventory.findAllDefaultInventories');
    Route::get('inventory/byuser/{id}', [InventoryController::class,'findAllInventoriesByUserId'])->name('inventory.findAllInventoriesByUserId');
    Route::get('inventory/last/byuser/{id}', [InventoryController::class,'findLastInventoryByUserID'])->name('inventory.findLastInventoryByUserID');
    Route::get('box/lastbox/{userid}', [BoxController::class,'findLastBoxByUserID'])->name('box.findLastBoxByUserID');
    Route::get('lastitem/{inventoryId}', [ItemController::class, 'findLastItemByInventory'])->name('item.findLastItem');
    Route::get('box/all-by-user/{userid}', [BoxController::class,'findAllBoxByUserID'])->name('box.findAllBoxByUserID');
    Route::get('box/all-item/{id}', [BoxController::class,'showItemByBox'])->name('box.showItemByBox');
    Route::get('lastitem', [ItemController::class,'findLastItem'])->name('item.findLastItem');
    Route::post('box/generateBoxAndCreateItemBox', [BoxController::class,'generateBoxAndCreateItemBox'])->name('box.generateBoxAndCreateItemBox');
});

