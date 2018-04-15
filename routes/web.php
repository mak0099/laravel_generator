<?php

Route::get('/', ['as' => 'index', 'uses' => 'HomeController@home']);
Route::get('/crud-generator/index', ['as' => 'crud_index', 'uses' => 'CrudController@index']);
Route::get('/crud-generator/add-crud', ['as' => 'add_crud', 'uses' => 'CrudController@addCrud']);
Route::post('/crud-generator/save-crud', ['as' => 'save_crud', 'uses' => 'CrudController@saveCrud']);
Route::get('/crud-generator/add-field', ['as' => 'add_field', 'uses' => 'CrudController@addField']);
Route::post('/crud-generator/save-field-item', ['as' => 'save_field_item', 'uses' => 'CrudController@saveFieldItem']);
Route::get('/crud-generator/delete-field-item/{index}', ['as' => 'delete_field_item', 'uses' => 'CrudController@deleteFieldItem']);
Route::get('/crud-generator/save-field', ['as' => 'save_field', 'uses' => 'CrudController@saveField']);
Route::get('/crud-generator/crud-option/{crud_id}', ['as' => 'crud_option', 'uses' => 'CrudController@crudOption']);
Route::post('/crud-generator/crud-generate/{crud_id}', ['as' => 'generate_crud', 'uses' => 'CrudController@generateCrud']);

Route::resource('Moderator','ModeratorController');
