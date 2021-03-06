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

Route::get('/', 'Site\HomeController@index')->name("site.home");
Route::post("/logout", "Auth\LoginController@logout")->name("logout");

//Auth::routes();

Route::prefix("painel")->group(function() {
    Route::get('/', 'Admin\HomeController@index')->name('admin');    
    
    Route::get("/login", "Auth\LoginController@index")->name("login");
    Route::post("/login", "Auth\LoginController@authenticate");
    
    Route::get("/register", "Auth\RegisterController@index")->name("register");
    Route::post("/register", "Auth\RegisterController@register");
    
    Route::resource("users", "Admin\UserController");
    Route::resource("pages", "Admin\PageController");

    Route::get("/profile", "Admin\ProfileController@index")->name("profile");
    Route::put("/profile", "Admin\ProfileController@update")->name("profile.update");

    Route::get("/settings", "Admin\SettingController@index")->name("settings");
    Route::put("/settings", "Admin\SettingController@update")->name("settings.update");
});

Route::fallback('Site\PageController@index');


