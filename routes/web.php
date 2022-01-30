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
use Illuminate\Support\Facades\Route;

//Our routes:
//Home
Route::get('/','Auth\LoginController@home')->name('home');

//Authentication
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register', 'Auth\RegisterController@register');
Route::get('/forget-password','Auth\PasswordResetController@showForgetPasswordForm')->name('forget_password_form');
Route::post('/forget-password','Auth\PasswordResetController@submitForgetPasswordForm')->name('forget_password');
Route::get('/reset-passoword/{token}','Auth\PasswordResetController@showResetPasswordForm')->name('reset_password_form');
Route::post('/reset-password','Auth\PasswordResetController@submitResetPasswordForm')->name('reset_password');

//FAQ 
Route::get('/faq','FaqController@show')->name('faq');

//About us
Route::get('/about','SobreNosController@show')->name('about-us');

//Contacts
Route::get('/contacts','ContactsController@show')->name('contacts');

//Main Features
Route::get('/main-features','MainFeaturesController@show')->name('main_features');

//Timeline
Route::get('genfeed','TimelineController@generalTimeline')->name('general_feed');
Route::get('fyf','TimelineController@personalizedTimeline')->name('for_you_feed');

Route::get('/choose-path','UserController@choosePath')->name('choose_path');
Route::post('/user/estudante','UserController@createEstudante')->name('new_student');
Route::post('/user/docente','UserController@createDocente')->name('new_teacher');

//Posts
Route::post('/api/post/create','PostController@create')->name('create_post');
Route::delete('/api/post/{id}','PostController@delete')->name('delete_post');
Route::get('/api/post/{id}','PostController@updatePost')->name('update_post');
Route::post('/api/post/{id}','PostController@editPost')->name('edit_post');

//Comments
Route::post('/api/comment/create/{id}','CommentController@create')->name('create_comment');
Route::delete('/api/comment/{id}','CommentController@delete')->name('delete_comment');
Route::get('/api/comment/{id}','CommentController@updateComment')->name('update_comment');
Route::post('/api/comment/{id}','CommentController@editComment')->name('edit_comment');

//Likes
Route::post('/api/like/create-post/{id}','LikeController@createPost')->name('create_like_post');
Route::post('/api/like/create-comment/{id}','LikeController@createComment')->name('create_like_comment');
Route::delete('/api/like/delete-post/{id}','LikeController@deletePost')->name('delete_like_post');
Route::delete('/api/like/delete-comment/{id}','LikeController@deleteComment')->name('delete_like_comment');

//Admin
Route::prefix('/admin')->name('admin.')->namespace('Admin')->group(function() {    
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('admin-users','AdminController@view')->name('admin_view_users');
    Route::post('ban-users/{id}','AdminController@banUser')->name('ban_user');
    Route::post('unban-users/{id}','AdminController@unbanUser')->name('unban_user');
    Route::delete('delete-user/{id}','AdminController@deleteUser')->name('delete_user_admin');
});

//User
Route::get('/profile/{id}','UserController@showProfile')->name('show_profile');
Route::get('/config/{id}','UserController@config_view')->name('config_view');
Route::post('/config/{id}','UserController@config')->name('config_user');
Route::delete('/users/{id}','UserController@delete')->name('delete_user');

//Friendships
Route::get('/users/friends','UserController@showFriends')->name('show_friends');
Route::post('/accept_friend/{id}','UserController@accept_friendship_request')->name('accept_friendship_request');
Route::post('/reject_friendship_request/{id}','UserController@reject_friendship_request')->name('reject_friendship_request');
Route::post('/send-friendship-request/{id}','UserController@sendFriendshipRequest')->name('send_friendship_request');
Route::delete('/breakup/{id}','UserController@breakup')->name('breakup');

//Search
Route::get('/api/search-results-vis','SearchController@searchVis')->name('search_vis');
Route::get('/api/search-results-aut','SearchController@searchAut')->name('search_aut');

//Notifications
Route::get('/notifications','NotificacaoController@show')->name('show_notifications');
Route::post('/notifications-viewed/{id}','NotificacaoController@viewed')->name('check-notifications');

//Groups
Route::get('/groups/{id}','GrupoController@show')->name('show_group');
Route::get('/group-members/{id}','GrupoController@showMembers')->name('show_group_members');
Route::delete('/group-delete/{id}','GrupoController@delete')->name('delete_group');
Route::delete('/group-leave/{id}','GrupoController@leave')->name('leave_group');
Route::get('/groups-create-view','GrupoController@getCreateView')->name('create_group_view');
Route::post('/groups-create','GrupoController@create')->name('create_group');
Route::get('/group-edit/{id}','GrupoController@update')->name('edit_view');
Route::post('/group-edit/{id}','GrupoController@edit')->name('edit_group');
Route::post('/group/{id}/add/{id_user}','GrupoController@addMember')->name('addmember_group');
Route::delete('/group/{id}/delete/{id_user}','GrupoController@deleteMember')->name('deletemember_group');
Route::post('/group/{id}/reject/{id_user}','GrupoController@rejectRequest')->name('reject_join_request');
Route::post('/group-ask-to-join/{id}','GrupoController@askToJoin')->name('ask_to_join_group');
Route::get('/group-view-requests/{id}','GrupoController@viewRequests')->name('view_requests_group');
Route::post('/group/create-post/{id}','GrupoController@addPost')->name('create_post_group');
Route::post('/group/{id}/invite/{id_user}','GrupoController@sendRequestUser')->name('invite_user');
Route::post('/group/accept-invite/{id}','GrupoController@acceptJoin')->name('accept_invite');
Route::post('/group/reject-invite/{id}','GrupoController@rejectJoin')->name('reject_invite');
Route::get('/group/invite-users/{id}','GrupoController@getUsersToInvite')->name('get_users_invite');
