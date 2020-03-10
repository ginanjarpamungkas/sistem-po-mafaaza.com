<?php

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes([ 'register' => false ]);
Route::group(['middleware' => 'auth'],function(){
    // dashboard
    Route::get('/home','DashboardController@index')->name('dashboard');
    Route::get('/po/show', 'PurchaseOrderController@index')->name('po.show');
    Route::get('/po/delete/{id}', 'PurchaseOrderController@destroy')->name('po.delete');
    Route::get('/po/edit/{id}', 'PurchaseOrderController@edit')->name('po.edit');
    Route::get('/po/view/{id}', 'PurchaseOrderController@show')->name('po.view');
    Route::get('/po/update/{id}', 'PurchaseOrderController@update')->name('po.update');
    Route::post('/po/update/detail/{id}', 'PurchaseOrderController@updateDetail')->name('po.detail.action');
    Route::get('/po/ceked/{id}','PurchaseOrderController@ceked')->name('po.ceked');
    //purchase order
    //gudang
    Route::group(['middleware' => ['permission:Create PO']], function () {
        Route::get('/po/create', 'PurchaseOrderController@create')->name('po.create');
        Route::post('/po/store', 'PurchaseOrderController@store')->name('po.store');
    });
    //supervisor
    Route::group(['middleware' => ['role:Supervisor']], function () {
        
    });
    
    Route::group(['middleware' => ['role:Administrator']], function () {
        // user management
        Route::get('/daftar/user', 'UserController@getData')->name('user.index');
        Route::get('/create/user', 'UserController@create')->name('user.create');
        Route::post('/edit/user/{id}', 'UserController@edit')->name('user.edit');
        Route::post('/update/user', 'UserController@update')->name('user.update');
        Route::post('/store/user', 'UserController@store')->name('user.store');
        Route::delete('/deleteUser/{id}','UserController@destroy')->name('user.delete');
        // Role Permission
        Route::resource('/role', 'RoleController')->except([
            'create', 'show', 'edit', 'update'
        ]);
        Route::get('/user/roles/{id}', 'UserController@roles')->name('user.roles');
        Route::put('/user/roles/{id}', 'UserController@setRole')->name('user.set_role');
        Route::post('/user/permission', 'UserController@addPermission')->name('user.add_permission');
        Route::get('/user/role-permission', 'UserController@rolePermission')->name('user.roles_permission');
        Route::put('/user/permission/{role}', 'UserController@setRolePermission')->name('user.setRolePermission');
    });

    // logout
    Route::get('logout', 'Auth\LoginController@logout');
});
