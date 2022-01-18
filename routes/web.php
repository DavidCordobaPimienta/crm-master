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

Route::get('/getListarRoles', 'Administracion\RolesController@getListarRoles');
Route::get('/administracion/roles/getListarPermisosByRol', 'Administracion\RolesController@getListarPermisosByRol');
Route::post('/setRegistrarRolPermisos','Administracion\RolesController@setRegistrarRolPermisos');
Route::post('/setEditarRolPermisos','Administracion\RolesController@setEditarRolPermisos');

Route::get('/administracion/permisos/getListarPermisos', 'Administracion\PermissionController@getListarPermisos');
Route::post('/setRegistrarPermiso','Administracion\PermissionController@setRegistrarPermiso');

Route::post('/setRegistrarUsuarios', 'Administracion\UsersController@setRegistrarUsuarios');
Route::post('/setEditarUsuarios', 'Administracion\UsersController@setEditarUsuarios');
Route::post('/setCambiarEstadoUsuario', 'Administracion\UsersController@setCambiarEstadoUsuario');
Route::get('administracion/usuarios/getListarUsuarios', 'Administracion\UsersController@getListarUsuarios');

Route::get('/{optional?}', function () {
    return view('app');
})->name('basepath')
  ->where('optional','.*');