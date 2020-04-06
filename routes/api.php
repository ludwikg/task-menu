<?php

Route::post('/menus', 'MenuController@store');
Route::get('/menus/{menuId}', 'MenuController@show')->where('menuId', '[0-9]+');
Route::put('/menus/{menuId}', 'MenuController@update')->where('menuId', '[0-9]+');
Route::patch('/menus/{menuId}', 'MenuController@update')->where('menuId', '[0-9]+');
Route::delete('/menus/{menuId}', 'MenuController@destroy')->where('menuId', '[0-9]+');

Route::post('/menus/{menuId}/items', 'MenuItemController@store')->where('menuId', '[0-9]+');
Route::get('/menus/{menuId}/items', 'MenuItemController@show')->where('menuId', '[0-9]+');
Route::delete('/menus/{menuId}/items', 'MenuItemController@destroy')->where('menuId', '[0-9]+');

Route::get('/menus/{menuId}/layers/{layer}', 'MenuLayerController@show')->where('menu', '[0-9]+')->where('layer', '[0-9]+');
Route::delete('/menus/{menuId}/layers/{layer}', 'MenuLayerController@destroy')->where('menu', '[0-9]+')->where('layer', '[0-9]+');

Route::get('/menus/{menu}/depth', 'MenuDepthController@show');

Route::post('/items', 'ItemController@store');
Route::get('/items/{itemId}', 'ItemController@show')->where('itemId', '[0-9]+');
Route::put('/items/{itemId}', 'ItemController@update')->where('itemId', '[0-9]+');
Route::patch('/items/{itemId}', 'ItemController@update')->where('itemId', '[0-9]+');
Route::delete('/items/{itemId}', 'ItemController@destroy')->where('itemId', '[0-9]+');

Route::post('/items/{itemId}/children', 'ItemChildrenController@store')->where('itemId', '[0-9]+');
Route::get('/items/{itemId}/children', 'ItemChildrenController@show')->where('itemId', '[0-9]+');
Route::delete('/items/{itemId}/children', 'ItemChildrenController@destroy')->where('itemId', '[0-9]+');

Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found.'], 404);
});
