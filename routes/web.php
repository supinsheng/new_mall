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
define("ROOT",base_path().'/');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','Home\IndexController@index');

// 后台主页
Route::get('/admin/index','Admin\IndexController@index');
Route::get('/admin/home','Admin\IndexController@home');

// 商品模块
Route::get('/admin/brand','Admin\GoodsController@brand');
Route::get('/admin/specification','Admin\GoodsController@specification');
Route::get('/admin/type_template','Admin\GoodsController@type_template');
Route::get('/admin/item_cat','Admin\GoodsController@item_cat');
Route::get('/admin/goods','Admin\GoodsController@goods');

// 商品品牌管理
Route::post('/goods/saveBrand','Admin\GoodsController@saveBrand');
Route::post('/goods/editBrand','Admin\GoodsController@editBrand');
Route::get('/goods/delBrand','Admin\GoodsController@delBrand');
Route::get('/goods/getBrandByAjax','Admin\GoodsController@getBrandByAjax');

// 商品分类管理
Route::post('/goods/saveCat','Admin\GoodsController@saveCat');
Route::get('/goods/getCatByAjax','Admin\GoodsController@getCatByAjax');
Route::post('/goods/editCat','Admin\GoodsController@editCat');
Route::get('/goods/delCat','Admin\GoodsController@delCat');

// 商品亲自管理
// 添加商品
Route::get('/goods/add','Admin\GoodsController@add');
Route::get('/goods/ajax_get_cat','Admin\GoodsController@ajax_get_cat');
Route::post('/goods/insert','Admin\GoodsController@insert');
// 编辑商品
Route::get('/goods/edit','Admin\GoodsController@edit');
// 执行编辑
Route::post('/goods/doEdit','Admin\GoodsController@doEdit');
// 删除商品 
Route::get('/goods/delGood','Admin\GoodsController@delGood');

// 广告管理
Route::get('/admin/ad_category','Admin\AdController@ad_category');
Route::get('/admin/ad','Admin\AdController@ad');


// RBAC模块管理
// 管理员管理
Route::get('/admin/admin','Admin\AdminController@index');
// 添加管理员
Route::post('/admin/saveAdmin','Admin\AdminController@saveAdmin');
// Ajax 获取管理员
Route::get('/admin/getAdminByAjax','Admin\AdminController@getAdminByAjax');
// 修改管理员
Route::post('/admin/editAdmin','Admin\AdminController@editAdmin');
// 删除管理员
Route::get('/admin/delAdmin','Admin\AdminController@delAdmin');

// 角色管理
Route::get('/admin/role','Admin\RoleController@index');
// 添加角色
Route::post('/role/saveRole','Admin\RoleController@saveRole');
// Ajax 获取角色
Route::get('/role/getRoleByAjax','Admin\RoleController@getRoleByAjax');
// 修改角色
Route::post('/role/editRole','Admin\RoleController@editRole');
// 删除角色
Route::get('/role/delRole','Admin\RoleController@delRole');

// 权限模块
Route::get('/admin/privilege','Admin\PrivilegeController@index');
// 添加权限
Route::post('/privilege/savePri','Admin\PrivilegeController@savePri');
// Ajax获取权限
// Route::get('/privilege/getPriByAjax','Admin\PrivilegeController@getPriByAjax');
// 修改权限
// Route::post('/privilege/editPri','Admin\PrivilegeController@editPri');
// 删除权限
Route::get('/privilege/delPri','Admin\PrivilegeController@delPri');
