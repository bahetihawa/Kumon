<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', "UtilityController@index");
//Route::get('/Location', 'UtilityController@index');
Auth::routes();
//Route::get('/home', 'HomeController@index');


Route::group(['middleware' => 'auth'], function() {
   Route::get('/home', 'HomeController@index')->name('home');
   Route::get('/setup/locations', [
	'uses'=>'SetUpController@index',
	'as'=>'location'
   ]);
	Route::get('/setup/centers', [
	'uses'=>'SetUpController@centers',
	'as'=>'center'
	]);
        Route::get('/setup/warehouses', [
	'uses'=>'SetUpController@warehouse',
	'as'=>'warehouse'
	]);
        Route::get('/organiger/catagories', [
	'uses'=>'OrganigerController@index',
	'as'=>'catagory'
	]);
   Route::post('/setup-create}', [
	'uses'=>'SetUpController@create',
	'as'=>'setup.create'
	]);
   Route::post('/organiger-create}', [
	'uses'=>'OrganigerController@create',
	'as'=>'organiger.create'
	]);
	Route::post('/setup-addForm}', [
	'uses'=>'SetUpController@addForm',
	'as'=>'setup.addForm'
	]);
   Route::post('/setup/states', 'SetUpController@states');
   Route::post('//orgniser/getvalue', 'OrganigerController@getvalue');
   Route::post('/setup/getCenter', 'SetUpController@getCenter');
	Route::get('/setup-delet/{model}/{id}', [
	'uses'=>'SetUpController@deleteEntry',
	'as'=>'setup.delete'
	]);
    Route::get('/organiser-delet/{model}/{id}', [
	'uses'=>'OrganigerController@deleteEntry',
	'as'=>'organiser.delete'
	]);
    Route::get('/organiger/tree', 'OrganigerController@tree')->name('organiger.tree');
    Route::get('/organiger/levels', 'OrganigerController@levels')->name('organiger.levels');
    Route::match(['get','post'],'/organiger/Items', 'OrganigerController@Items')->name('organiger.Items');
    
    Route::post('/users/resetPassword', [
	'uses'=>'UsersController@resetPassword',
	'as'=>'users.resetPassword'
	]);
    Route::post('/utility/rename', 'UtilityController@rename');
    Route::post('/utility/registerCenter', 'UtilityController@registerCenter');
    Route::match(['get', 'post'],'/users/integration', 'UsersController@integration')->name('integration');
    Route::resource('users', 'UsersController');
    Route::resource('center', 'CenterController');
    
    
    Route::get('/inventory/orders/{store}', [
	'uses'=>'InventoryController@orders',
	'as'=>'inventory.orders'
	]);
    Route::get('/inventory/stockCenters', 'InventoryController@stockCenter')->name('inventory.stockCenter');
    Route::match(['get', 'post'],'/inventory/stockWarehouses/{store}', 'InventoryController@stockWarehouses')->name('inventory.stockWarehouses');
    Route::match(['get', 'post'],'/inventory/wksLevel/{store}', 'InventoryController@wksLevel')->name('inventory.wksLevel');
    Route::match(['get', 'post'],'/inventory/wks/{store}', 'InventoryController@wks')->name('inventory.wks');
    Route::get('/inventory/create', 'InventoryController@create')->name('inventory.create');
    Route::get('/inventory/transfer', 'InventoryController@transfer')->name('inventory.transfer');
    Route::get('/inventory/render', 'InventoryController@render')->name('inventory.render');
    Route::match(['get','post'],'/addItemList', 'OrganigerController@addItemList')->name('addItemList');
   
    Route::match(['get', 'post'],'/stock', 'WarehouseController@stock')->name('stock');
    Route::match(['get', 'post'],'/wksLevel', 'WarehouseController@wksLevel')->name('wksLevel');
    Route::match(['get', 'post'],'/wks', 'WarehouseController@wks')->name('wks');
    Route::match(['get', 'post'],'/stockCenters/{cent}', 'WarehouseController@stockCenter')->name('stockCenter');
    Route::match(['get', 'post'],'/stockCentersCiNci/{cent}', 'WarehouseController@stockCenterCiNci')->name('stockCentersCiNci');
    Route::match(['get', 'post'],'/stockWarehouses', 'WarehouseController@stockWarehouses')->name('stockWarehouses');
    Route::match(['get', 'post'], '/create', 'WarehouseController@create')->name('create');
    Route::match(['get', 'post'],'/transfer/{cent}', 'WarehouseController@transfer')->name('transfer');
    Route::match(['get', 'post'],'/consume/{cent}', 'WarehouseController@consume')->name('consume');
    Route::match(['get', 'post'],'/return/{cent}', 'WarehouseController@return')->name('return');
    Route::match(['get', 'post'],'/render/{cent}', 'WarehouseController@render')->name('render');
    Route::match(['get', 'post'], '/consignments', 'WarehouseController@consignments')->name('consignments');
    Route::match(['get', 'post'], '/addCharges', 'WarehouseController@addCharges')->name('addCharges');
    Route::match(['get', 'post'], '/updatePrice', 'WarehouseController@updatePrice')->name('updatePrice');
    
    Route::get('/download/{file}', "UtilityController@download")->name("download");
    Route::get('/downloadRender/{file}', "UtilityController@downloadRender")->name("downloadRender");
    Route::get('/getGrn/{file}', "UtilityController@getGrn")->name("getGrn");
    Route::get('/getDn/{file}', "UtilityController@getDn")->name("getDn");
    Route::get('/getTn/{file}', "UtilityController@getTn")->name("getTn");
    Route::match(['get','post'],'/getCent', "UtilityController@getCent")->name("getCent");
    Route::match(['get','post'],'/stockStatus', "UtilityController@stockStatus")->name("stockStatus");
    Route::match(['get','post'],'/stockStatusAll', "UtilityController@stockStatusAll")->name("stockStatusAll");

    Route::match(['get','post'],'/uploadStacks', "UtilityController@uploadStacks")->name("uploadStacks");
     //Route::match(['get','post'],'/stockCenter', "UtilityController@stockCenter")->name("stockCenter");
    
    Route::match(['get','post'],'/loadStacks', "UtilityController@loadStacks")->name("loadStacks");
    Route::match(['get','post'],'/opening', "StoreController@index")->name("opening");
     Route::match(['get','post'],'/openingW', "StoreController@openingW")->name("openingW");
    Route::match(['get','post'],'/matchStacks', "UtilityController@matchStacks")->name("matchStacks");
});
