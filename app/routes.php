<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Event::listen('illuminate.query', function($sql){
// 	var_dump($sql);
// });

// Route::get('/', function()
// {
// 	return View::make('hello');
// });

function user_id()
{
	return Auth::user()->id;
}
function organization_id()
{
	return Auth::user()->organization_id;
}
function user_photos_path()
{
	return public_path().'/images/profile/';
}
function client_photos_path()
{
	return public_path().'/images/clients/';
}

Route::get('/', 'AuthController@login');
Route::get('login', array('as' => 'login', 'uses' => 'AuthController@login'));
Route::get('logout', array('as' => 'logout', 'uses' => 'AuthController@logout'));
Route::post('register', array('before' => 'CSRF', 'as' => 'register', 'uses' => 'AuthController@register'));
Route::post('login', array('before' => 'CSRF', 'as' => 'login', 'uses' => 'AuthController@authentication'));

Route::get('login_reminders', array('as' => 'login_reminders', 'uses' => 'ChecklistRemindersController@index'));

Route::controller('password', 'RemindersController');

Route::group(array('before' => 'auth'), function()
{
	Route::get('profile', array('as' => 'profile', 'uses' => 'UserController@viewProfile'));

	Route::get('add-new-client', array('as' => 'add-new-client', 'uses' => 'ClientController@addClient'));
	Route::post('import-client', array('as' => 'import-client', 'uses' => 'ClientController@importCSVClientInfo'));
	Route::get('client/{id}/overview', array('as' => 'client.overview', 'uses' => 'ClientController@clientOverview'), function($id){
		return $id;
	});
	Route::get('client/{id}/update', array('as' => 'client.update', 'uses' => 'ClientController@clientEdit'), function($id){
		return $id;
	});
	Route::get('client/{id}/delete', array('as' => 'client.delete', 'uses' => 'ClientController@deleteClient'), function($id){
		return $id;
	});

	Route::get('add-new-user', array('as' => 'add-new-user', 'uses' => 'UserController@addNewUser'));

	/*Checklist Route - starts*/
	Route::get('create-new-checklist', array('as' => 'create-new-checklist', 'uses' => 'ChecklistController@addChecklist'));
	Route::get('view-checklist', array('as' => 'view-checklist', 'uses' => 'ChecklistController@showChecklist'));
	Route::get('view-demo-checklist', array('as' => 'view-demo-checklist', 'uses' => 'ChecklistController@demoChecklist'));
	Route::get('checklist/{id}/update', array('as' => 'checklist.update', 'uses' => 'ChecklistController@editChecklist'), function($id){
		return $id;
	});
	Route::post('checklist/{id}/update', array('before' => 'CSRF', 'as' => 'checklist.update', 'uses' => 'ChecklistController@updateChecklistInfo'), function($id){
			return $id;
	});
	Route::post('create-new-checklist', array('before' => 'CSRF', 'as' => 'create-new-checklist', 'uses' => 'ChecklistController@saveChecklistInfo'));
	Route::post('checklist/{id}/delete', array('before' => 'CSRF', 'as' => 'checklist.delete', 'uses' => 'ChecklistController@deleteChecklist'), function($id){
			return $id;
	});
	Route::get('checklist/{id}/copy', array('as' => 'checklist.copy', 'uses' => 'ChecklistController@copyChecklist'), function($id){
		return $id;
	});
	Route::post('checklist/{id}/copy', array('before' => 'CSRF', 'as' => 'checklist.copy', 'uses' => 'ChecklistController@saveCopiedChecklist'), function($id){
		return $id;
	});
	Route::post('import-checklist', array('before' => 'CSRF', 'as' => 'import-checklist', 'uses' => 'ChecklistController@importCSV'));
	Route::post('filter-checklist', array('before' => 'CSRF', 'as' => 'filter-checklist', 'uses' => 'ChecklistController@filterChecklist'));
	Route::post('search-checklist', array( 'as' => 'search-checklist', 'uses' => 'ChecklistController@searchChecklist'));
	// Route::get('filter-checklist', array('as' => 'filter-checklist', 'uses' => 'ChecklistController@filterChecklist'));
	/*Checklist Route - ends*/

	/*Task Route - starts*/
	Route::get('add-new-task', array('as' => 'add-new-task', 'uses' => 'TaskController@addNewTask'));
	Route::get('task/{id}/add', array('as' => 'task.add', 'uses' => 'TaskController@addTask'), function($id){
		return $id;
	});
	Route::post('create-new-task', array('before' => 'CSRF', 'as' => 'create-new-task', 'uses' => 'TaskController@saveTaskInfo'));
	Route::post('task/{id}/update', array('before' => 'CSRF', 'as' => 'task.update', 'uses' => 'TaskController@updateTaskInfo'), function($id){
			return $id;
	});
	Route::get('task/{id}/delete', array('before' => 'CSRF', 'as' => 'task.delete', 'uses' => 'TaskController@deleteTask'), function($id){
			return $id;
	});
	Route::get('task/{id}/copy', array('as' => 'task.copy', 'uses' => 'TaskController@copyTask'), function($id){
		return $id;
	});
	Route::get('task/{id}/details', array('as' => 'task.details', 'uses' => 'TaskController@show'), function($id){
		return $id;
	});
	Route::get('task/{id}/complete', array('as' => 'task.complete', 'uses' => 'TaskController@changeStatus'), function($id){
		return $id;
	});
	/*Task Route - ends*/	

	Route::post('profile', array('before' => 'CSRF', 'as' => 'profile', 'uses' => 'UserController@updateProfile'));
	Route::post('change-avatar', array('before' => 'CSRF', 'as' => 'change-avatar', 'uses' => 'UserController@changeAvatar'));
	Route::post('change-user-pass', array('before' => 'CSRF', 'as' => 'change-user-pass', 'uses' => 'UserController@changeUserPass'));

	Route::post('add-new-client', array('before' => 'CSRF', 'as' => 'add-new-client', 'uses' => 'ClientController@saveClientInfo'));
	Route::get('get-client-List', array('before' => 'CSRF', 'as' => 'get-client-List', 'uses' => 'ClientController@additionalContact'));
	Route::get('get-client-List-by-checklist', array('before' => 'CSRF', 'as' => 'get-client-List-by-checklist', 'uses' => 'ClientController@additionalContactByChecklist'));
	
	Route::post('client/{id}/update', array('before' => 'CSRF', 'as' => 'client.update', 'uses' => 'ClientController@updateClientInfo'), function($id){
			return $id;
	});

	Route::post('add-new-user', array('before' => 'CSRF', 'as' => 'add-new-user', 'uses' => 'UserController@saveUserInfo'));
	Route::get('user/{id}/overview', array('as' => 'user.overview', 'uses' => 'UserController@userOverview'), function($id){
		return $id;
	});
	Route::post('user/{id}/update', array('as' => 'user.update', 'uses' => 'UserController@userInfoUpdate'), function($id){
		return $id;
	});
	Route::get('user/{id}/delete', array('as' => 'user.delete', 'uses' => 'UserController@deleteUser'), function($id){
		return $id;
	});

	/*System admin route - starts*/
	Route::get('create-system-admin', array('as' => 'create-system-admin', 'uses' => 'SystemController@createNew'));
	Route::get('pricing', array('as' => 'pricing', 'uses' => 'SystemController@showPricing'));
	Route::post('create-new-package', array('as' => 'create-new-package', 'uses' => 'SystemController@createNewPricing'));
	Route::get('pricing/{id}/update', array('as' => 'pricing.update', 'uses' => 'SystemController@updatePricing'), function($id){
		return $id;
	});
	Route::post('pricing/{id}/update', array('as' => 'pricing.update', 'uses' => 'SystemController@updatePricingInfo'), function($id){
		return $id;
	});
	Route::get('paid-users', array('as' => 'paid-users', 'uses' => 'SystemController@paidUsers'));
	Route::get('system-admin', array('as' => 'system-admin', 'uses' => 'SystemController@systemAdmin'));
	Route::post('create-new-admin', array('as' => 'create-new-admin', 'uses' => 'SystemController@createNew'));
	Route::get('sys-admin/{id}/update', array('as' => 'sys-admin.update', 'uses' => 'SystemController@showInfo'), function($id){
		return $id;
	});
	Route::post('sys-admin/{id}/update', array('as' => 'sys-admin.update', 'uses' => 'SystemController@updateInfo'), function($id){
		return $id;
	});
	Route::get('demo-templates', array('as' => 'demo-templates', 'uses' => 'SystemController@demoTemplates'));
	Route::get('create-new-demo-checklist', array('as' => 'create-new-demo-checklist', 'uses' => 'SystemController@demoNewTemplates'));
	Route::post('create-new-demo-checklist', array('before' => 'CSRF', 'as' => 'create-new-demo-checklist', 'uses' => 'SystemController@saveChecklistInfo'));
	Route::post('create-new-demo-task', array('before' => 'CSRF', 'as' => 'create-new-demo-task', 'uses' => 'SystemController@saveTaskInfo'));
	/*System admin route -ends*/

	/*Subscription routes -starts*/
	Route::post('re-subscription', array('before' => 'CSRF', 'as' => 're-subscription', 'uses' => 'AuthController@reSubscription'));
	Route::post('cancel-subscription', array('before' => 'CSRF', 'as' => 'cancel-subscription', 'uses' => 'AuthController@cancelSubscription'));
	Route::post('upgrade-plan', array('before' => 'CSRF', 'as' => 'upgrade-plan', 'uses' => 'AuthController@upgradePlan'));
	Route::get('user/{id}/upgrade', array('as' => 'user.upgrade', 'uses' => 'SystemController@upgradePlan'), function($id){
		return $id;
	});
	Route::post('user/{id}/upgrade', array('before' => 'CSRF' ,'as' => 'user.upgrade', 'uses' => 'SystemController@upgradeTo'), function($id){
		return $id;
	});
	/*Subscription routes -ends*/

	

	Route::resource('checklist_reminders', 'ChecklistRemindersController');

	Route::resource('task_reminders', 'TaskRemindersController');

	Route::get('checklist-reminders', array('as' => 'checklist-reminders', 'uses' => 'ChecklistRemindersController@index'));
	Route::get('task-reminders', array('as' => 'task-reminders', 'uses' => 'TaskRemindersController@index'));

	/*Superadmin routes*/
	Route::get('basic-info', array('as' => 'basic-info', 'uses' => 'UserController@basicInfo'));
	Route::get('users', array('as' => 'users', 'uses' => 'UserController@all'));
	Route::get('clients', array('as' => 'clients', 'uses' => 'ClientController@all'));
	/*ends*/
});