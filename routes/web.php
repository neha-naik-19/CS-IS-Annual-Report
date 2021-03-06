<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\ViewdetaileddataController;
use App\Http\Controllers\BibtexController;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/login-alert', function () {
    return view('auth.loginalert');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

// Route::get('/publication', function () {
//     return view('Publication.index');
// });

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::resource('publication', 'PublicationController');
    Route::resource('view', 'ViewController');
    Route::resource('print', 'PrintController');
    Route::resource('searchedit', 'SearcheditController');
    Route::resource('updatedata','UpdatedataController');
    Route::resource('viewdata','ViewdetaileddataController');
    Route::resource('bibtex','BibtexController');
});

/* Login Routes */
Route::get('bitsemailauthenticate', [App\Http\Controllers\Auth\LoginController::class, 'callajax']);

/* Publication Routes */
Route::post('writetodb', [App\Http\Controllers\PublicationController::class, 'store']);
Route::post('foo', [App\Http\Controllers\PublicationController::class, 'foo']);
Route::post('getcategory', [App\Http\Controllers\PublicationController::class, 'getcategory']);
Route::get('readfromdb', [App\Http\Controllers\PublicationController::class, 'show']);
Route::get('category', [App\Http\Controllers\PublicationController::class, 'showarticle']);

Route::post('gettitle', [App\Http\Controllers\PublicationController::class, 'get_title_data']);
Route::get('check_title_duplication', [App\Http\Controllers\PublicationController::class, 'check_dup_title']);

Route::post('getconference', [App\Http\Controllers\PublicationController::class, 'get_conference_data']);
Route::get('check_conference_duplication', [App\Http\Controllers\PublicationController::class, 'check_dup_conference']);

/* Print Routes */
Route::get('printsearch', [App\Http\Controllers\PrintController::class, 'action']);
Route::get('printpagination', [App\Http\Controllers\PrintController::class, 'index']);
Route::post('printformdata', [App\Http\Controllers\PrintController::class, 'postform']);

//fromdate ajax post
Route::post('printfromdate', [App\Http\Controllers\PrintController::class, 'postfromdate']);

//todate ajax post
Route::post('printtodate', [App\Http\Controllers\PrintController::class, 'posttodate']);

//todate ajax post
Route::post('printtodate', [App\Http\Controllers\PrintController::class, 'posttodate']);

//authortype ajax post
Route::post('printauthortype', [App\Http\Controllers\PrintController::class, 'postauthortype']);

//category ajax post
Route::post('printcategory', [App\Http\Controllers\PrintController::class, 'postcategory']);

//nationality ajax post
Route::post('printnationality', [App\Http\Controllers\PrintController::class, 'postnationality']);

//title ajax post
Route::post('printtitle', [App\Http\Controllers\PrintController::class, 'posttitle']);

//conference ajax post
Route::post('printconference', [App\Http\Controllers\PrintController::class, 'postconference']);

//author ajax post
Route::post('printauthor', [App\Http\Controllers\PrintController::class, 'postauthor']);

//ranking ajax post
Route::post('printranking', [App\Http\Controllers\PrintController::class, 'postranking']);

/************************************************************************************/
/* Search Routes */
Route::post('getcategorysearch', [App\Http\Controllers\SearcheditController::class, 'getcategory']);
Route::get('getarticlesearch', [App\Http\Controllers\SearcheditController::class, 'showarticle']);
Route::post('autocompletefetch', [App\Http\Controllers\SearcheditController::class, 'getautocomplete']);
Route::post('displaysearch',[App\Http\Controllers\SearcheditController::class, 'getsearchresult']);
Route::post('deletesearch/{id}', [App\Http\Controllers\SearcheditController::class, 'destroy']);
Route::get('allrankings', [App\Http\Controllers\SearcheditController::class, 'showrankings']);
Route::get('editsearch', [App\Http\Controllers\SearcheditController::class, 'showauthor']);
Route::get('loginuser',[App\Http\Controllers\SearcheditController::class, 'loginuser']);

/************************************************************************************/
/* Print Routes */
Route::get('dynamic_pdf/pdf', [App\Http\Controllers\PrintController::class, 'loadpdf']);
Route::get('dynamic_word/wordexport', [App\Http\Controllers\PrintController::class, 'createworddocx']);

/* Update Publication Routes */
Route::get('publicationupdate/{id}', [App\Http\Controllers\UpdatedataController::class, 'index']);
Route::post('updatetodb', [App\Http\Controllers\UpdatedataController::class, 'store']);

/* Page Expired Route */
Route::get('/CS-IS/login-expire', function () {
    return view('pageexpired');
});

Route::get('login/{website}', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('login/{website}/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

Route::get('showranking',[PublicationController::class, 'showrankings']);

Route::get('showbroadarea',[PublicationController::class, 'showbroadarea']);

/************************************************************************************/
/* View Routes */
Route::get('viewsearch', [App\Http\Controllers\ViewController::class, 'showviewauthor']);
Route::post('displayviewsearch',[App\Http\Controllers\ViewController::class, 'getviewsearchresult']);
Route::get('publicationview/{id}', [App\Http\Controllers\ViewdetaileddataController::class, 'index']);

/************************************************************************************/
/* BibTex Routes */

Route::post('readbibtex', [App\Http\Controllers\BibtexController::class, 'store']);
Route::post('getfiledata', [App\Http\Controllers\BibtexController::class, 'get_file_data']);
Route::get('checkduplication', [App\Http\Controllers\BibtexController::class, 'display_duplicate_on_js']);


