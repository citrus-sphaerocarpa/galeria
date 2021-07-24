<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Mail\NewUserWelcomeMail;


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

Route::group([
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function()
    {
        /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
        Route::get('/', function () {
            return view('welcome');
        });

        // Auth
        Auth::routes();
        
        // Verification
        Auth::routes(['verify' => true]);

        Route::get('/email/verify', function () {
            return view('auth.verify');
        })->middleware('auth')->name('verification.notice');

        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect('/home')->with('flash_message', __('Your email address was successfully verified.'));
        })->middleware(['auth', 'signed'])->name('verification.verify');

        // Home
        Route::get('/home', [App\Http\Controllers\PostsController::class, 'index']);
// Comment
Route::delete('/p/{post}/comment/{comment}', [App\Http\Controllers\CommentsController::class, 'destroy'])->name('comment.destroy');
        // Comment
        Route::get('/p/{post}/comment/create', [App\Http\Controllers\CommentsController::class, 'create']);
        Route::get('/p/{post}/comment/{comment}/create', [App\Http\Controllers\CommentsController::class, 'createReply']);
        Route::get('/p/{post}/comment/{comment}/edit', [App\Http\Controllers\CommentsController::class, 'edit']);
        Route::post('/p/{post}/comment/{comment}', [App\Http\Controllers\CommentsController::class, 'storeReply'])->name('comment.storeReply');
        Route::patch('/p/{post}/comment/{comment}', [App\Http\Controllers\CommentsController::class, 'update'])->name('comment.update');
        Route::post('/p/{post}/comment', [App\Http\Controllers\CommentsController::class, 'store'])->name('comment.store');

        // Chat
        Route::get('/chat/private/{username}', [App\Http\Controllers\ChatsController::class, 'show']);
        Route::get('/chat', [App\Http\Controllers\ChatsController::class, 'index']);
        
        // Favorite
        Route::get('/favorite', [App\Http\Controllers\FavoritesController::class, 'index']);

        // Follow
        Route::get('/follow', [App\Http\Controllers\FollowsController::class, 'index']);

        // Notifications
        Route::get('/notifications', [App\Http\Controllers\NotificationsController::class, 'index']);

        // Post
        Route::get('/p/create', [App\Http\Controllers\PostsController::class, 'create']);
        Route::get('/p/favoriting', [App\Http\Controllers\PostsController::class, 'fetchFavoritingPosts']);
        Route::get('/p/following', [App\Http\Controllers\PostsController::class, 'fetchFollowingPosts']);
        Route::get('/p/{post}/edit', [App\Http\Controllers\PostsController::class, 'edit']);
        Route::patch('/p/{post}', [App\Http\Controllers\PostsController::class, 'update'])->name('post.update');
        Route::delete('/p/{post}', [App\Http\Controllers\PostsController::class, 'destroy'])->name('post.destroy');
        Route::get('/p/{post}', [App\Http\Controllers\PostsController::class, 'show']);
        Route::post('/p', [App\Http\Controllers\PostsController::class, 'store']);
        
        // Profile
        Route::get('/profile/{username}/edit', [App\Http\Controllers\ProfilesController::class, 'edit']);
        Route::patch('/profile/{username}', [App\Http\Controllers\ProfilesController::class, 'update'])->name('profile.update');
        Route::get('/profile/{username}', [App\Http\Controllers\ProfilesController::class, 'index']);
        
        // Search
        Route::get('/search', [App\Http\Controllers\SearchController::class, 'showSearchResults']);
        Route::get('/search/tag', [App\Http\Controllers\SearchController::class, 'showSearchTagResults']);

        // Setting
        Route::get('/settings/account/delete', [App\Http\Controllers\SettingsController::class, 'deleteAccount']);
        Route::delete('/settings/account/delete', [App\Http\Controllers\SettingsController::class, 'destroyAccount']);
        Route::get('/settings/account/edit', [App\Http\Controllers\SettingsController::class, 'editAccount']);
        Route::patch('/settings/account/edit', [App\Http\Controllers\SettingsController::class, 'updateAccount'])->name('settings.updateAccount');
        Route::get('/settings/account', [App\Http\Controllers\SettingsController::class, 'showAccount']);
        Route::get('/settings/notifications', [App\Http\Controllers\NotificationsController::class, 'show']);
        Route::patch('/settings/notifications', [App\Http\Controllers\NotificationsController::class, 'update'])->name(('settings.update'));
        Route::get('/settings/security/password/', [App\Http\Controllers\PasswordsController::class, 'index']);
        Route::post('/settings/security/password/', [App\Http\Controllers\PasswordsController::class, 'changePassword']);
        Route::get('/settings/security', [App\Http\Controllers\SettingsController::class, 'showSecurity']);
        Route::get('/settings', [App\Http\Controllers\SettingsController::class, 'index']);
        
});

Route::get('/app', function () {
    return view('layouts.app');
});



// Notification
Route::get('/notifications/fetch', [App\Http\Controllers\NotificationsController::class, 'fetchNotifications']);

// Follow
Route::post('/follow/{user}', [App\Http\Controllers\FollowsController::class, 'store']);

// Favorite
Route::post('/favorite/{post}', [App\Http\Controllers\FavoritesController::class, 'store']);
Route::get('/tags', [App\Http\Controllers\PostsController::class, 'fetchTags']);

// Profile
Route::get('/profile/{username}/posts', [App\Http\Controllers\ProfilesController::class, 'fetchPosts']);

// Chat
Route::get('/privatemessages/{uuid}', [App\Http\Controllers\MessagesController::class, 'fetchPrivateMessages']);
Route::post('/privatemessages/{uuid}', [App\Http\Controllers\MessagesController::class, 'sendPrivateMessage']);

// Search
Route::get('/search/tag/fetch/{key}', [App\Http\Controllers\SearchController::class, 'fetchTaggedPosts']);
Route::get('/search/fetch/{key}', [App\Http\Controllers\SearchController::class, 'fetchSearchResults']);

