<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// webhook stripe
Route::post('stripe_webhook', 'Client\Common\StripeController@handleWebhook');
Route::post('connect_webhook', 'Client\Common\StripeController@handleConnectWebhook');
Route::post('get_content', 'Client\Common\ImagePathController@getContent');
Route::post('read_message', 'Client\Student\MyPageController@updateReadMessage');
//Route::get('read_email', 'Portal\ImapController@countEmailUnseen');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
