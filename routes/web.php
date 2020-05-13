<?php
Route::post('/get-select-options', ['as' => 'get-select-options', 'uses' => 'DashboardController@getSelectOptions']);
Route::get('/',  function(){
    return redirect()->route('dashboard');
})->name('index');
Route::group(['prefix' => 'dashboard'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', ['as' => 'login', 'uses' => 'DashboardController@login']);
        Route::post('login', ['as' => 'attempt_login', 'uses' => 'DashboardController@attemptLogin']);
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', ['as' => 'logout', 'uses' => 'DashboardController@logout']);
        Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@dashboard']);
        Route::get('/profile', ['as' => 'profile', 'uses' => 'DashboardController@view_profile']);
        Route::put('/update-profile', ['as' => 'update_profile', 'uses' => 'DashboardController@update_profile']);
        Route::put('/update-password', ['as' => 'update_password', 'uses' => 'DashboardController@update_password']);
        Route::get('/move-item', ['as' => 'move_item', 'uses' => 'DashboardController@move_item']);
        Route::get('/change-activation', ['as' => 'change_activation', 'uses' => 'DashboardController@change_activation']);
        Route::get('/change-feature', ['as' => 'change_feature', 'uses' => 'DashboardController@change_feature']);
        Route::get('/crud-generator/index', ['as' => 'crud_index', 'uses' => 'CrudController@index']);
        Route::get('/crud-generator/add-crud', ['as' => 'add_crud', 'uses' => 'CrudController@addCrud']);
        Route::post('/crud-generator/save-crud', ['as' => 'save_crud', 'uses' => 'CrudController@saveCrud']);
        Route::get('/crud-generator/add-field', ['as' => 'add_field', 'uses' => 'CrudController@addField']);
        Route::post('/crud-generator/save-field-item', ['as' => 'save_field_item', 'uses' => 'CrudController@saveFieldItem']);
        Route::get('/crud-generator/delete-field-item/{index}', ['as' => 'delete_field_item', 'uses' => 'CrudController@deleteFieldItem']);
        Route::get('/crud-generator/save-field', ['as' => 'save_field', 'uses' => 'CrudController@saveField']);
        Route::get('/crud-generator/crud-option/{crud_id}', ['as' => 'crud_option', 'uses' => 'CrudController@crudOption']);
        Route::post('/crud-generator/crud-generate/{crud_id}', ['as' => 'generate_crud', 'uses' => 'CrudController@generateCrud']);
        
        Route::get('/database/{database}/exportation', ['as' => 'database.exportation', 'uses' => 'DatabaseController@exportation']);
        Route::post('/database/{database}/export', ['as' => 'database.export', 'uses' => 'DatabaseController@export']);
        Route::get('/database/{database}/table/{table}/api-crud', ['as' => 'database.table.api_crud', 'uses' => 'TableController@api_crud']);
        Route::post('/database/{database}/table/{table}/export-api-crud', ['as' => 'database.table.export_api_crud', 'uses' => 'TableController@export_api_crud']);
        Route::resource('database', 'DatabaseController');
        Route::resource('database.table', 'TableController');
        Route::resource('database.table.column', 'ColumnController');
    });
});
