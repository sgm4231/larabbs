<?php

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

Route::get('/', 'TopicsController@index')->name('root');

//Auth::routes();等同于以下
// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 用户注册相关路由
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// 密码重置相关路由
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Email 认证相关路由
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
//Auth::routes();等同于以上




Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);
//等同于
//显示用户个人信息页面
//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//显示编辑个人资料页面
//Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
//处理 edit 页面提交的更改
//Route::patch('/users/{user}', 'UsersController@update')->name('users.update');
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);


Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

//话题发布图片上传
Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

//URI 参数 topic 是 『隐性路由模型绑定』 的提示，将会自动注入 ID 对应的话题实体。
//URI 最后一个参数表达式 {slug?} ，? 意味着参数可选
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

//只需要 store 和 destroy 的路由
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

//通知列表
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

//无权限访问后台的提醒
Route::get('permission-denied', 'PagesController@permissionDenied')->name('permission-denied');