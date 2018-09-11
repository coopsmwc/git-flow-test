<?php

use Illuminate\Http\Request;

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/company/{company}/admin-tabs','ApiController@adminTabs')->name('sales-admin-tabs');
Route::get('/{company}/admin-tabs','ApiController@adminTabs')->name('company-admin-tabs');
Route::post('/{company}/admins','ApiController@admins')->name('api-company-admins');
Route::post('/{company}/administrator/create', 'ApiController@createAdminUser')->name('api-admin-create');
Route::put('/{company}/administrator/{administrator}','ApiController@updateAdminUser')->name('api-admin-create');
