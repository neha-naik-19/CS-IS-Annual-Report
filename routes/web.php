<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/CS-IS/login', function () {
    return view('auth.login');
    return view('auth.logincopy');
});

Route::get('/CS-IS/login-alert', function () {
    return view('auth.loginalert');
});

Auth::routes();

Route::get('/CS-IS/home', [App\Http\Controllers\HomeController::class, 'index'],['name' => 'Taylor']);

// Route::get('/publication', function () {
//     return view('Publication.index');
// });

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::resource('publication', 'PublicationController');
    Route::resource('print', 'PrintController');
    Route::resource('searchedit', 'SearcheditController');
    Route::resource('updatedata','UpdatedataController');
});

/* Login Routes */
Route::get('bitsemailauthenticate', [App\Http\Controllers\Auth\LoginController::class, 'callajax']);

/* Publication Routes */
Route::post('writetodb', [App\Http\Controllers\PublicationController::class, 'store']);
Route::post('foo', [App\Http\Controllers\PublicationController::class, 'foo']);
Route::post('getcategory', [App\Http\Controllers\PublicationController::class, 'getcategory']);
Route::get('readfromdb', [App\Http\Controllers\PublicationController::class, 'show']);
Route::get('category', [App\Http\Controllers\PublicationController::class, 'showarticle']);

/* Print Routes */
Route::get('printsearch', [App\Http\Controllers\PrintController::class, 'action']);
Route::get('printpagination', [App\Http\Controllers\PrintController::class, 'index']);
Route::post('printformdata', [App\Http\Controllers\PrintController::class, 'postform']);
Route::get('dynamic_pdf/pdf', [App\Http\Controllers\PrintController::class, 'loadpdf']);
Route::get('dynamic_word/wordexport', [App\Http\Controllers\PrintController::class, 'createworddocx']);

/* Search Routes */
Route::post('getcategorysearch', [App\Http\Controllers\SearcheditController::class, 'getcategory']);
Route::get('getarticlesearch', [App\Http\Controllers\SearcheditController::class, 'showarticle']);
Route::post('autocompletefetch', [App\Http\Controllers\SearcheditController::class, 'getautocomplete']);
Route::post('displaysearch',[App\Http\Controllers\SearcheditController::class, 'getsearchresult']);
Route::post('deletesearch/{id}', [App\Http\Controllers\SearcheditController::class, 'destroy']);
Route::get('allrankings', [App\Http\Controllers\SearcheditController::class, 'showrankings']);
Route::get('editsearch', [App\Http\Controllers\SearcheditController::class, 'showauthor']);

/* Update Publication Routes */
Route::get('publicationupdate/{id}', [App\Http\Controllers\UpdatedataController::class, 'index']);
Route::post('updatetodb', [App\Http\Controllers\UpdatedataController::class, 'store']);

/* Page Expired Route */
Route::get('/CS-IS/login-expire', function () {
    return view('pageexpired');
});

Route::get('login/{website}', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('login/{website}/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);