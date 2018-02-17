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
use App\Applicant;
use Illuminate\Support\Facades\Input;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' =>'admin','middleware' => 'auth'], function (){

	Route::get('/category/create',[
 	'uses' => 'CategoriesController@create',
 	'as' => 'category.create'
 	]);

	Route::Post('/category/store',[
		'uses' => 'CategoriesController@store',
		'as' => 'category.store'
	]);

	Route::GET('/categories',[
		'uses' => 'CategoriesController@index',
		'as' => 'categories'
	]);

	Route::get('/job',[
		'uses' => 'JobsController@index',
		'as' => 'jobs'
	]);

	Route::get('/job/create',[
		'uses' => 'JobsController@create',
		'as' => 'job.create'
	]);

	Route::Post('/job/store',[
		'uses' => 'JobsController@store',
		'as' => 'job.store'
	]);
	Route::Get('/singleCategoryJobs/{id}',[
		'uses' => 'JobsController@singleCategoryJobs',
		'as' => 'singleCategoryJobs'
	]);

	Route::Get('/applicant/index',[
		'uses' =>'ApplicantController@index',
		'as' => 'applicants'
	]);
	Route::Get('/applicant/single_Cat_Job/{id}',[
		'uses' => 'ApplicantController@single_Cat_Job',
		'as' => 'single_cat_jobs'
	]);
	Route::Get('/applicant/single/{id}',[
		'uses' =>'ApplicantController@singleApplicant',
		'as' => 'applicant.single'
	]);
	Route::Get('/applicant/delete/{id}',[
		'uses'=> 'ApplicantController@destroy',
		'as'=> 'applicant.delete' 
	]);

	Route::Get('/applicant/trashed',[
		'uses' => 'ApplicantController@trashed',
		'as' => 'applicant.trashed'
	]);

	Route::Get('/applicant/kill/{id}',[
		'uses' => 'ApplicantController@kill',
		'as' => 'applicant.kill'
	]);
	Route::Get('/applicant/restore/{id}',[
		'uses' => 'ApplicantController@restore',
		'as' => 'applicant.restore'
	]);
	Route::Get('/applicant/hire/{id}',[
		'uses' => 'ApplicantController@hire',
		'as' => 'applicant.hire'
	]);
	Route::Get('/applicant/retire/{id}',[
		'uses' => 'ApplicantController@retire',
		'as' => 'applicant.retire'
	]);
	
	Route::Get('/applicants/hired',[
		'uses' => 'ApplicantController@hiredApplicants',
		'as' => 'applicants.hired'
	]);
	Route::Get('/user/create',[
		'uses' => 'UsersController@create',
		'as' => 'user.create'
	]);
	Route::Get('/users',[
		'uses' => 'UsersController@index',
		'as' => 'users'
	]);
	Route::Post('/user/store',[
		'uses' => 'UsersController@store',
		'as' => 'user.store'
	]);
	Route::Get('/user/admin/{id}',[
		'uses' => 'UsersController@admin',
		'as' => 'user.admin'
	]);
	Route::Get('/user/not_admin/{id}',[
		'uses' => 'UsersController@Not_Admin',
		'as' => 'user.not_admin'
	]);
});
	Route::Get('/applicant/apply',[
		'uses' => 'ApplicantController@create',
		'as' => 'applicant.apply'
	]);

	Route::Post('/applicant/store',[
		'uses' => 'ApplicantController@store',
		'as' => 'applicant.store'
	]);

	Route::get('/findjob','ApplicantController@findjob');

	//Route::get('/ajax-job',function(){
	//		$cat_id = Input::get('cat_id');
	//	$jobs = Jobs::where('category_id', '=',$cat_id)->get();
	//	return Response::json($jobs);
	// });


Route::any('/search',function(){
    $q = Input::get ( 'q' );
    $applicant = Applicant::where('city','LIKE','%'.$q.'%')->get();
    if(count($applicant) > 0)
        return view('searchview')->withDetails($applicant)->withQuery ( $q );
    else return view ('searchview')->withMessage('No Details found. Try to search again !');
});