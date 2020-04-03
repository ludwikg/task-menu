<?php

Route::post('/menus', 'MenuController@store');
Route::get('/menus/{menuId}', 'MenuController@show');
Route::put('/menus/{menuId}', 'MenuController@update');
Route::patch('/menus/{menuId}', 'MenuController@update');
Route::delete('/menus/{menuId}', 'MenuController@destroy');

Route::post('/menus/{menuId}/items', 'MenuItemController@store');
Route::get('/menus/{menu}/items', 'MenuItemController@show');
Route::delete('/menus/{menu}/items', 'MenuItemController@destroy');

Route::get('/menus/{menu}/layers/{layer}', 'MenuLayerController@show');
Route::delete('/menus/{menu}/layers/{layer}', 'MenuLayerController@destroy');

Route::get('/menus/{menu}/depth', 'MenuDepthController@show');

Route::post('/items', 'ItemController@store');
Route::get('/items/{item}', 'ItemController@show');
Route::put('/items/{item}', 'ItemController@update');
Route::patch('/items/{item}', 'ItemController@update');
Route::delete('/items/{item}', 'ItemController@destroy');

Route::post('/items/{item}/children', 'ItemChildrenController@store');
Route::get('/items/{item}/children', 'ItemChildrenController@show');
Route::delete('/items/{item}/children', 'ItemChildrenController@destroy');

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found.'], 404);
});
