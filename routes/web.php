<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/','Controller@login')->name('user.login');
// Route::post('/','Controller@autenticar')->name('user.auth');

Route::get('/', function () {
    if (auth()->guest()) {
        return redirect()->route('login');
    } else {
        return redirect()->route('home');
    }
});
Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('admin-area', 'AdminAreaController@index')->name('admin.area');
    Route::get('admin-area/machines', 'AdminAreaController@machines')->name('admin.area.machines');
    Route::get('admin-area/users', 'AdminAreaController@users')->name('admin.area.users');

    Route::resource('machines', 'MaquinasController')->except('index')->middleware('auth');
    Route::resource('images', 'ImagesController')->middleware('auth');

    Route::get('containers', 'ContainersController@index')->name('containers.index');
    Route::get('containers-config', 'ContainersController@configureContainer')->name('containers.configure');
    Route::get('terminal-tab/{docker_id}', 'ContainersController@terminal')->name('container.terminalTab');
    Route::get('containers/loading/{id}', 'ContainersController@loading')->name('container.loading');
    Route::resource('containers', 'ContainersController')->except(['create', 'index']);
    Route::get('containers/play-stop/{containerId}', 'ContainersController@playStop')->name('containers.playStop');
    Route::post('containers/{docker_id}/delete', 'ContainersController@deleteContainer')->name('container.delete');

    Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('table-list', function () {
            return view('pages.table_list');
        })->name('table');

        Route::get('user-machines', 'MaquinasController@machines')->name('user.machines');
    });

        Route::resource('user', 'UserController', ['except' => ['show']]);
        Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
        Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
        Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::resource('services', 'ServiceController');
    Route::get('docker-swarm', 'DockerSwarmController@index')->name('docker-swarm.index');
    Route::post('docker-swarm', 'DockerSwarmController@swarmInit')->name('docker-swarm.init');
    Route::post('docker-swarm/leave', 'DockerSwarmController@swarmLeave')->name('docker-swarm.leave');

    Route::prefix('settings')->group(function(){
        Route::get('/', 'SettingsController@index')->name('settings.index');
        Route::put('/service-template/update', 'SettingsController@updateServiceTemplate')->name('service-template.update');
        Route::put('/container-template/update', 'SettingsController@updateContainerTemplate')->name('container-template.update');
        Route::put('/volume-driver-template/update', 'SettingsController@updateVolumeDriver')->name('volume-driver.update');
        Route::get('/phpinfo', 'SettingsController@phpinfo')->name('settings.phpinfo');
    });

    Route::resource('user-categories', 'UserCategoryController', ['except' => ['show', 'index', 'create', 'edit']]);

    Route::prefix('swarm-nodes')->group(function(){
        Route::get('/', 'NodesController@index')->name('nodes.index');
        Route::put('/{id}/{version}', 'NodesController@updateNode')->name('nodes.update');
        Route::delete('/{id}', 'NodesController@destroyNode')->name('nodes.destroy');
    });

});
