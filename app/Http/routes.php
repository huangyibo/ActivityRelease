<?php

# ------------------ Page Route ------------------------
Route::get('/', 'PagesController@home')->name('home');
Route::get('/feed', 'PagesController@feed')->name('feed');
Route::get('/sitemap', 'PagesController@sitemap');
Route::get('/sitemap.xml', 'PagesController@sitemap');
Route::get('/search', 'PagesController@search')->name('search');

Route::group(['middleware' => ['auth', 'admin_auth']], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration Routes... 请自行开启注册功能
 Route::get('register', 'Auth\AuthController@getRegister');
 Route::post('register', 'Auth\AuthController@postRegister');

// Password Reset Routes...  请自行开启注册功能
 Route::get('password/reset', 'Auth\PasswordController@getEmail');
 Route::post('password/email', 'Auth\PasswordController@postEmail');
 Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
 Route::post('password/reset', 'Auth\PasswordController@postReset');

 // Users 编辑资料：修改头像 消息通知 账号绑定
Route::get('users/{id}/edit_avatar', 'UsersController@edit_avatar');

Route::post('users/{id}/update_avatar', 'UsersController@update_avatar');
Route::get('users/{id}/edit_email_notify', 'UsersController@edit_email_notify');
Route::get('users/{id}/edit_social_binding', 'UsersController@edit_social_binding');
Route::get('users/{id}/edit_password', 'UsersController@edit_password');
Route::post('users/{id}/update_password', 'UsersController@update_password');

Route::get('test', 'UsersController@test');

Route::get('users/{id}/posts/released', 'UsersController@userReleasedPosts');
Route::get('users/{id}/posts/apply_detail', 'UsersController@postDetailsList');

Route::get('posts/{post_id}/applicants', 'ApplicantsController@listByPostId');
Route::post('posts/cover/upload', 'PostController@uploadCover');

Route::resource('users', 'UsersController', ['only' => ['show', 'edit', 'update']]);
Route::resource('posts', 'PostController', ['only' => ['show', 'create', 'store', 'update', 'edit']]);
Route::resource('categories', 'CategoryController', ['only' => ['show']]);

Route::resource("issues","IssueController", ['only' => ['show', 'index']]);
Route::resource("applicants", 'ApplicantsController', ['only' => ['store']]);

Route::resource('post_phases', 'PostPhaseController', ['only' => ['destroy']]);

// update user
//Route::post('users/{id}/update', 'UsersController@update');

// Company Main Page: the introduction about company
Route::get('company/about', 'CompanyController@getCompanyIntroduction');