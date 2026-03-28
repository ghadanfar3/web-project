<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;



//theme routes
Route::controller(ThemeController::class)->group(function (){
    Route::get("/", 'index')->name('index') ;
    Route::get("/category/{id}", 'category')->name('category') ;
    Route::get("/contact", 'contact')->name('contact') ;
});

//subscriber store route
Route::post('/subscriber/store' , [SubscriberController::class, 'store' ])->name('subscriber.store') ;

Route::post('/contact/store' , [ContactController::class , 'store'])->name('contact.store') ;

//Blog Routes
Route::get('my-blogs' , [BlogController::class , 'myBlogs'])->name('blogs.my-blog');
Route::get('/user/{user}', [themeController::class, 'blogs'])->name('user.blogs');
Route::resource('blogs' , BlogController::class)->except('index') ;

//Comment Routes
Route::post('comment/store', [CommentController::class , 'store'])->name('comments.store');


require __DIR__.'/auth.php';


