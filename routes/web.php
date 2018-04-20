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

Route::any('/register', function() {
	abort(403);
});
Route::get('/home', 'HomeController@index')->name('home');
//Employee Login
Route::get('/employee/login', [
	'as' => 'employee.login',
	'uses' => 'EmployeeController@EmployeeLogin'
]);
Route::post('/employee/login', [
	'as' => 'employee.login',
	'uses' => 'EmployeeController@postEmployeeLogin'
]);


Route::get('/employee/profile', [
	'as' => 'employee.profile',
	'uses' => 'EmployeeController@EmployeeProfile'
]);
Route::post('/employee/profile/{id}', [
	'as' => 'employee.profile.update',
	'uses' => 'EmployeeController@UpdateEmployeeProfile'
]);


Route::post('/employee/logout', [
	'as' => 'employee.logout',
	'uses' => 'EmployeeController@EmployeeLogout'
]);

//docs List

Route::get('/docs/list', [
	'as' => 'documents.list',
	'uses' => 'EmployeeController@showDocs'
]);
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

	Route::get('/category/edit/{id}',[
		'uses' => 'CategoriesController@edit',
		'as' => 'category.edit'
	]);
	Route::Post('/category/update/{id}',[
		'uses' => 'CategoriesController@update',
		'as' => 'category.update'
	]);

	Route::get('/category/delete/{id}',[
		'uses' => 'CategoriesController@delete',
		'as' => 'category.delete'
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
	Route::get('/job/edit/{id}',[
		'uses' => 'JobsController@edit',
		'as' => 'job.edit'
	]);
	Route::Post('/job/update/{id}',[
		'uses' => 'JobsController@update',
		'as' => 'job.update'
	]);
	Route::get('/job/delete',[
		'uses' => 'JobsController@delete',
		'as' => 'job.delete'
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
	Route::get('/user/delete/{id}',[
		'uses' => 'UsersController@delete',
		'as' => 'user.delete'
	]);
	Route::Get('/user/admin/{id}',[
		'uses' => 'UsersController@admin',
		'as' => 'user.admin'
	]);
	Route::Get('/user/not_admin/{id}',[
		'uses' => 'UsersController@Not_Admin',
		'as' => 'user.not_admin'
	]);
	Route::Get('/user/Activate/{id}',[
		'uses' => 'UsersController@ActivateUser',
		'as' => 'user.activate'
	]);
	Route::Get('/user/Disable/{id}',[
		'uses' => 'UsersController@DisableUser',
		'as' => 'user.disable'
	]);
	Route::Get('/employees',[
		'uses' => 'EmployeeController@index',
		'as' => 'employees'
	]);
	Route::Get('/employee/create',[
		'uses' => 'EmployeeController@create',
		'as' => 'employee.create'
	]);
	Route::Post('/employee/store',[
		'uses' => 'EmployeeController@store',
		'as' => 'employee.store'
	]);
	//edit
	Route::get('/employee/edit/{id}',[
		'uses' => 'EmployeeController@edit',
		'as' => 'employee.edit'
	]);

	//update
	Route::Post('/employee/update/{id}',[
		'uses' => 'EmployeeController@update',
		'as' => 'employee.update'
	]);

	//trash
	Route::Get('/employee/trashed',[
		'uses' => 'EmployeeController@trashed',
		'as' => 'employee.trashed'
	]);

	Route::Get('/employee/kill/{id}',[
		'uses' => 'EmployeeController@kill',
		'as' => 'employee.kill'
	]);
	Route::Get('/employee/restore/{id}',[
		'uses' => 'EmployeeController@restore',
		'as' => 'employee.restore'
	]);

	
	//Delete Employee
	Route::Post('/employee/delete/{id}',[
		'uses' => 'EmployeeController@destroy',
		'as' => 'employee.destroy'
	]);

	//attendance
	Route::Get('/attendance',[
		'uses' => 'AttendanceController@index',
		'as' => 'attendance'
	]);

	//upload Docs
	Route::get('/upload/docs',[
		'as' => 'documents.upload',
		'uses' => 'DocumentsController@index'
	]);

	Route::post('/upload/docs',[
		'as' => 'documents.upload',
		'uses' => 'DocumentsController@uploadDocs'
	]);
	Route::post('/upload/status/{id}',[
		'as' => 'documents.status',
		'uses' => 'DocumentsController@statusChange'
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

	Route::get('sendmail', 'SendMailController@sendMail');

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
Route::get('welcome-mail','UserController@welcomeMail');