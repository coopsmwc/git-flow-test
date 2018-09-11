<?php
//Route::get('/mmlayout', 'LayoutController@index')->name('layout'); // For Mike Mcann

Route::get('/{company}/login', 'Auth\Company\LoginController@showLoginForm')->name('company-admin-login');
Route::post('/{company}/login', 'Auth\Company\LoginController@login');
Route::post('/{company}/logout', 'Auth\Company\LoginController@logout')->name('company-logout');
Route::match(['get', 'post'], '/{company}/logout', 'Auth\Company\LoginController@logout')->name('company-logout');

Auth::routes();

Route::group( ['middleware' => ['auth', 'sales-admin']], function () {
    Route::get('/sales-admins','UserAdminController@index')->name('sales-admins');
    Route::resource('/sales-admin', 'UserAdminController')->except(['index']);
    Route::post('/company/{company}/suspend', 'CompanyController@suspend')->name('suspend');
    Route::post('/company/{company}/activate', 'CompanyController@activate')->name('activate');
    Route::post('/company/{company}/activate-licence', 'CompanyController@activateLicence')->name('activate-licence');
    Route::post('/company/{company}/deactivate-licence', 'CompanyController@deactivateLicence')->name('deactivate-licence');
    Route::post('/company/{company}/auto-renew', 'CompanyController@autoRenew')->name('auto-renew');
    Route::post('/company/{company}/cancel-auto-renew', 'CompanyController@cancelAutoRenew')->name('cancel-auto-renew');
    Route::resource('/company/{company}/administrator', 'CompanyAdminController', ['as' => 'company']);
    Route::resource('/company/{company}/domain', 'CompanyDomainController', ['as' => 'company']);
    Route::resource('/company/{company}/email', 'CompanyEmailController', ['as' => 'company']);
    Route::get('/companies','CompanyController@index')->name('companies');
    Route::get('/home','CompanyController@index')->name('companies-home');
    Route::get('/company/create','CompanyController@create')->name('company.details.create');
    Route::post('/company','CompanyController@store')->name('company.details.store');
    Route::resource('/company/{company}/details', 'CompanyController', ['as' => 'company'])->except(['index', 'create', 'store']);
    Route::get('/company/{company}/dashboard','CompanyController@dashboard')->name('company-company-dashboard');
    Route::get('/company/{company}/manage-users','CompanyController@manageUsers')->name('company-company-manage-users');
});

Route::group( ['middleware' => ['auth']], function () {
    Route::get('/', 'AdminController@landing')->name('landing');
    Route::get('/changePassword','AdminController@showChangePasswordForm');
    Route::post('/changePassword','AdminController@changePassword')->name('changePassword');
});

Route::get('/logout','Auth\LoginController@logout');

Route::group( ['middleware' => 'company-admin'], function () {
    Route::resource('/{company}/details', 'CompanyController')->except(['index']);
    Route::resource('/{company}/administrator', 'CompanyAdminController')->except(['index']);
    Route::resource('/{company}/domain', 'CompanyDomainController')->except(['index']);
    Route::resource('/{company}/email', 'CompanyEmailController')->except(['index']);
    Route::get('/{company}', 'CompanyAdminController@dashboard')->name('company-admin-home');
    Route::get('/{company}/employee/remove','EmployeeController@employeeRemove')->name('employee-remove.show');
    Route::post('/{company}/employee/remove','EmployeeController@remove')->name('employee-remove.remove');
    Route::get('/{company}/manage-users','CompanyController@manageUsers')->name('company-manage-users');
    Route::get('/{company}/account-admins','CompanyAdminController@adminList')->name('company-account-admins');
    Route::get('/{company}/credentials', 'CompanyController@credentials')->name('company-credentials');
    Route::put('/{company}/credentials/{id}', 'CompanyController@storeCredentials')->name('company-credentials.update');
});

Route::group( ['middleware' => ['employee-credentials', 'revalidate']], function () {
    Route::get('/{company}/register', 'EmployeeController@index')->name('employee-register');
    Route::post('/{company}/register', 'EmployeeController@credentials')->name('employee-register.post');
    Route::get('/{company}/my-possible-self/register', 'EmployeeController@mpsShowRegisterForm')->name('mps-employee-register');
    Route::get('/{company}/my-possible-self/registered', 'EmployeeController@registrationConfirm')->name('mps-employee-registered');
    Route::post('/{company}/my-possible-self/register', 'EmployeeController@mpsEmployeeRegister')->name('mps-employee-register.post');
});