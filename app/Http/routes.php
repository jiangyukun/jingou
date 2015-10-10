<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'WelcomeController@index');

Route::get('home', 'WelcomeController@index');
/*
|--------------------------------------------------------------------------
| 登录注册
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function ()
{
    $Authority = 'Auth\AuthorityController@';
    Route::get('login', ['middleware' => 'guest', 'as' => 'login', 'uses' => $Authority . 'loginGet']);
    Route::post('login', ['middleware' => 'guest', 'uses' => $Authority . 'loginPost']);
    Route::get('logout', ['middleware' => 'auth', 'as' => 'logout', 'uses' => $Authority . 'logout']);


    Route::get('retrieve', $Authority . 'retrieve');
    Route::get('atest', $Authority . 'atest');

    Route::get('register', ['middleware' => 'guest', 'as' => 'register', 'uses' => $Authority . 'registerGet']);
    Route::post('register', ['middleware' => 'guest', 'uses' => $Authority . 'registerPost']);
    Route::post('is_username_exist', ['middleware' => 'guest', 'uses' => $Authority . 'isUsernameExist']);
    Route::post('is_mobile_exist', ['middleware' => 'guest', 'uses' => $Authority . 'isMobileExist']);

    Route::post('getRegCode', $Authority . 'getRegCode');
    Route::post('checkMobileCode', $Authority . 'checkMobileCode');

    Route::get('certImg/{id}/{type}', $Authority . 'getCertImg');

    Route::get('cert', ['middleware' => 'auth', 'as' => 'cert', 'uses' => $Authority . 'cert']);
    Route::post('cert', ['middleware' => 'auth', 'as' => 'cert', 'uses' => $Authority . 'certPost']);
    Entrust::routeNeedsRole('auth/cert', ['bidder']);
});


/*
|--------------------------------------------------------------------------
| 发布竞价
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'demand'], function ()
{
    $Demand = 'DemandController@';
    Route::get('list', $Demand . 'index');
    Route::get('search/{keyword}', $Demand . 'search');
    Route::get('post', $Demand . 'post');
    Route::post('post', $Demand . 'add');
    Route::get('postadd', $Demand . 'add');

    Route::post('getInfo', $Demand . 'getInfo');
    Route::get('getInfo', $Demand . 'getInfo');
    Route::get('cate', $Demand . 'getCategories');
    Route::get('show/{id}', $Demand . 'showDemand');
    Route::get('cancel/{id}', $Demand . 'cancelDemand');
    Route::get('my', $Demand . 'myDemandsByType');
    Route::get('my/{type}', $Demand . 'myDemandsByType');
    Route::post('win', $Demand . 'win');

    Route::get('list/cate/{id}', $Demand . 'index')->where('id', '[0-9]+');

    Route::get('atest', $Demand . 'atest');
    Route::get('getinfo', $Demand . 'gettbinfo');
    Route::get('delay/{id}', $Demand . 'delaya')->where('id', '[0-9]+');
    Route::post('delay/{id}', $Demand . 'delaya')->where('id', '[0-9]+');
    Route::get('/delivery/{id}', $Demand . 'delivery')->where('id', '[0-9]+');;
    Route::get('/fav/', $Demand . 'fav');
    Route::get('/choose/{id?}', $Demand . 'choose')->where('id', '[0-9]+');
    Route::post('/choose/{id?}', $Demand . 'choose')->where('id', '[0-9]+');
    Route::post('shouhuo', $Demand . 'shouhuo');

    Entrust::routeNeedsRole('demand/post', array('tenderee', 'admin'), null, false);
});

Route::group(['prefix' => 'bid'], function ()
{
    $Bid = 'BidController@';
    Route::post('add', $Bid . 'addBid');
    Route::get('my', $Bid . 'myBidsByType');
    Route::get('cancel/{id}', $Bid . 'cancelBid');
    Route::get('my/{type}', $Bid . 'myBidsByType');
    Route::get('express', $Bid . 'myexpress');
    Route::get('myinfo', $Bid . 'myinfo');
    //  Route::post('savehuo', $Bid . 'savehuo');
    Route::match(['get', 'post'], 'f/{id}', $Bid . 'fahuo')->where('id', '[0-9]+');
    Route::match(['get', 'post'], 'sk/{id}', $Bid . 'shoukuan')->where('id', '[0-9]+');

});

Route::group(['prefix' => 'pay'], function ()
{
    $Pay = 'PayController@';
    Route::get('deposit/{id}', $Pay . 'deposit');
    Route::post('deposit/{id}', $Pay . 'payDeposit');
    Route::get('demand/{id}', $Pay . 'demand');
    Route::post('demand/{id}', $Pay . 'payDemand');

    Route::get('payorder/bidder', $Pay . 'bidderdeposit'); //商家支付保证金
    Route::post('payorder/bidder', $Pay . 'bidderdeposit'); //商家支付保证金

    Route::post('paybank', $Pay . 'paybank'); //商家支付保证金

    Route::get('payorder/{id}', $Pay . 'payorder');
    Route::get('back/', $Pay . 'backorder');
    Route::get('address/{id}', $Pay . 'address');

    Route::get('atest/', $Pay . 'atest');
    Route::post('alipayapi/', $Pay . 'alipayapi');
    Route::post('action/', $Pay . 'action');
    Route::post('saveaddr/', $Pay . 'saveaddr');
});


Route::group(['prefix' => 'ajax'], function ()
{
    $ajax = 'ajaxController@';
    Route::get('index', $ajax . 'index');
    Route::get('category', $ajax . 'category');
    Route::get('area', $ajax . 'area');
    Route::get('brand', $ajax . 'brand');
    Route::get('cate', $ajax . 'ajax_cate');
    Route::get('ajax_col', $ajax . 'ajax_col');
    Route::get('ajax_brand', $ajax . 'ajax_brand');
    Route::get('ajax_demand', $ajax . 'ajax_demand');

});
/*
|--------------------------------------------------------------------------
| 管理员后台
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function ()
{
    $Admin = 'Admin\AdminController@';
    Route::get('index', $Admin . 'index');
    Route::get('setting', $Admin . 'setting');
    Route::post('setting', $Admin . 'saveset');
    Route::get('demands', $Admin . 'demandManage');
    Route::post('demands', $Admin . 'demandManage');
    Route::get('users', $Admin . 'userManage');
    Route::get('bids', $Admin . 'bidManage');
    Route::get('d_demand/{id}', $Admin . 'delDemand');


    Route::post('sdemand/{id}', $Admin . 'sdemand')->where('id', '[0-9]+');
    Route::post('savebid/{id}', $Admin . 'savebid')->where('id', '[0-9]+');
    Route::post('savedeli/{id}', $Admin . 'savedeli')->where('id', '[0-9]+');

    Route::get('dedit/{id}', $Admin . 'editDemand')->where('id', '[0-9]+');
    Route::post('dedit/{id}', $Admin . 'editDemand')->where('id', '[0-9]+');
    Route::get('debid/{id}', $Admin . 'Demandbid')->where('id', '[0-9]+');

    Route::get('d_user/{id}', $Admin . 'delUser');
    Route::get('d_bid/{id}', $Admin . 'delBid');
    Route::get('e_bid/{id}', $Admin . 'editBid');
    Route::get('user/{id}', $Admin . 'user');
    Route::post('user/{id}', $Admin . 'user');
    Route::get('atest/{id?}', $Admin . 'atest');

    Route::get('bidders', $Admin . 'bidders');
    Route::get('cate', $Admin . 'cate');
    Route::post('cate', $Admin . 'cate');

    Route::get('brand', $Admin . 'brand');
    Route::post('brand', $Admin . 'brand');

    Route::get('cate/{id}', $Admin . 'cate')->where('id', '[0-9]+');
    Route::get('cate/add/{id?}', $Admin . 'addcate')->where('id', '[0-9]+');
    Route::post('cate/add/{id?}', $Admin . 'addcate')->where('id', '[0-9]+');
    Route::post('cate/add', $Admin . 'addcate');
    Route::post('cate/sort', $Admin . 'sortcate');
    Route::get('editcate/{id}', $Admin . 'editcate')->where('id', '[0-9]+');
    Route::post('editcate/{id}', $Admin . 'editcate')->where('id', '[0-9]+');
    Route::get('delcate/{id}', $Admin . 'delcate')->where('id', '[0-9]+');
    Route::post('cate/delete', $Admin . 'deletecate')->where('id', '[0-9]+');

    Route::post('cert/{id}', $Admin . 'certPost');
    //  Route::get('cert/{id}', $Admin . 'certPost');


    Route::post('bidders', $Admin . 'biddersaudit');
    Route::get('certs', $Admin . 'certs');
});

//Entrust::routeNeedsRole( 'admin/set*', 'Admin' );

