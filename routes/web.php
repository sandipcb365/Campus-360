<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\Auth\PasswordlessAuthenticationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Courses\CoursesController;
use App\Http\Controllers\Dashboard\AdminDashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\UserDashboard\UserDashboardController;
use App\Http\Controllers\EducationInfoController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PersonalInfoController;
use App\Http\Controllers\UserBlogController;
use App\Http\Controllers\WorkInfoController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/course.php';
require __DIR__ . '/paidcourse.php';
require __DIR__ . '/cv.php';

Route::get('/cvhome', function () {
    return view('cvhome');
})->name('cvhome');

// Passwordless Authentication

//Route::middleware('guest')->group(function () {
Route::post('/login', [PasswordlessAuthenticationController::class, 'sendLink'])
    ->name('login');

Route::get('/login/{user}', [PasswordlessAuthenticationController::class, 'authenticateUser'])
    ->name('passwordless.authenticate');

Route::get('/', [MainController::class, 'HomePage'])->name('home');
Route::get('/courses', [CoursesController::class, 'CoursePage'])->name('courses');
//Route::get('/blog', [MainController::class, 'BlogPage'])->name('blog');
Route::get('/aboutus', [MainController::class, 'AboutUs'])->name('aboutus');
//});

// Main Blog Post
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/post_details/{id}', [BlogController::class, 'post_details']);
Route::get('/user_blog_details/{id}', [BlogController::class, 'user_blog_details']);

Route::middleware('auth')->group(function () {});

// USER DASHBOARD
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'UserDashboardPage'])->name('dashboard.user');
    Route::get('/useradd_blog', [UserBlogController::class, 'useradd_blog'])->name('user.add.blog');
    Route::post('/userpost_blog', [UserBlogController::class, 'userpost_blog'])->name('user.post.blog');;
    Route::get('/usershow_blog', [UserBlogController::class, 'usershow_blog'])->name('user.show.blog');;
    Route::get('/user_delete_blog/{id}', [UserBlogController::class, 'user_delete_blog'])->name('user.delete.blog');;
    Route::get('/user_edit_blog/{id}', [UserBlogController::class, 'user_edit_blog'])->name('user.edit.blog');;
    Route::post('/userupdate_blog/{id}', [UserBlogController::class, 'userupdate_blog'])->name('user.update.blog');
});

// Route::middleware(['auth', 'role:admin'])->group(function () {});

// Admin
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.admin');

    Route::post('/update-active-status/{encryptedUserId}', [AdminDashboardController::class, 'updateActiveStatus'])
        ->name('update.active.status');

    Route::post('/update-ad-slide-status/{encryptedUserId}', [AdminDashboardController::class, 'updateAdSlideStatus'])
        ->name('update.adSlide.status');

    Route::get('/edit-page/{id}', [AdminDashboardController::class, 'Edit_advertisement_slider_page']);
    Route::put('/edit-slider/{id}', [AdminDashboardController::class, 'Edit_advertisement_slider'])->name('edit-slider-page');

    Route::post('/add-carousel-slide', [AdminDashboardController::class, 'Create_slider'])->name('addslide');

    Route::put('/update-member-slide-visibility/{encryptedUserId}', [AdminDashboardController::class, 'updateVisibility'])->name('update.visibility');

    Route::put('/edit-member-page/{id}', [AdminDashboardController::class, 'Edit_member_slider'])->name('edit-member-page');

    Route::post('/add-member-carousel-slide', [AdminDashboardController::class, 'Create_member']);

    Route::get('/pagination/paginate-user-data', [AdminDashboardController::class, 'pagination']);

    Route::get('/search-user', [AdminDashboardController::class, 'searchUser'])->name('searchProduct');

    Route::post('/update-status', [AdminDashboardController::class, 'updateStatus'])->name('updateStatus');

    Route::post('/updateUserRole', [AdminDashboardController::class, 'updateUserRole'])->name('updateUserRole');
// Route for Blog
    Route::get('/admin_add_blog', [AdminBlogController::class, 'add_blog'])->name('admin.add.blog');
    Route::post('/post_blog', [AdminBlogController::class, 'post_blog'])->name('admin.post.blog');

    Route::get('/show_blog', [AdminBlogController::class, 'show_blog'])->name('admin.show.blog');
    Route::get('/manage_user_blog', [AdminBlogController::class, 'manage_user_blog'])->name('admin.manage.user.blog');
    Route::get('/delete_blog/{id}', [AdminBlogController::class, 'delete_blog'])->name('admin.delete.blog');
    Route::get('/delete_user_blog/{id}', [AdminBlogController::class, 'delete_user_blog'])->name('admin.delete.usre.blog');
    Route::get('/edit_blog/{id}', [AdminBlogController::class, 'edit_blog'])->name('admin.edit.blog');

    Route::post('/update_blog/{id}', [AdminBlogController::class, 'update_blog'])->name('admin.update.blog');
    Route::get('/accept_blog/{id}', [AdminBlogController::class, 'accept_blog'])->name('admin.accept.blog');
    Route::get('/reject_blog/{id}', [AdminBlogController::class, 'reject_blog'])->name('admin.reject.blog');
});

// Route for Blog
Route::get('/admin_add_blog', [AdminBlogController::class, 'add_blog'])->name('admin.add.blog');
Route::post('/post_blog', [AdminBlogController::class, 'post_blog'])->name('admin.post.blog');

Route::get('/show_blog', [AdminBlogController::class, 'show_blog'])->name('admin.show.blog');
Route::get('/manage_user_blog', [AdminBlogController::class, 'manage_user_blog'])->name('admin.manage.user.blog');
Route::get('/delete_blog/{id}', [AdminBlogController::class, 'delete_blog'])->name('admin.delete.blog');
Route::get('/delete_user_blog/{id}', [AdminBlogController::class, 'delete_user_blog'])->name('admin.delete.usre.blog');
Route::get('/edit_blog/{id}', [AdminBlogController::class, 'edit_blog'])->name('admin.edit.blog');

Route::post('/update_blog/{id}', [AdminBlogController::class, 'update_blog'])->name('admin.update.blog');
Route::get('/accept_blog/{id}', [AdminBlogController::class, 'accept_blog'])->name('admin.accept.blog');
Route::get('/reject_blog/{id}', [AdminBlogController::class, 'reject_blog'])->name('admin.reject.blog');

Route::get('/constructionsms', [MainController::class, 'ConstructionSmsPage'])
    ->name('constructionsms');

Route::get('/page-starter', [AdminDashboardController::class, 'pageStarter'])->name('pageStarter');

// Route For CV make
Route::get('/personal_info', [PersonalInfoController::class, 'index']);
Route::post('/store_personal', [PersonalInfoController::class, 'store_personal']);

Route::get('/education_info', [EducationInfoController::class, 'index']);
Route::post('/store_education', [EducationInfoController::class, 'store_education']);
Route::get('/education_summary', [EducationInfoController::class, 'education_summary']);
Route::get('/edit_education/{id}', [EducationInfoController::class, 'edit_education']);
Route::post('/update_education/{id}', [EducationInfoController::class, 'update_education']);

Route::get('/work_info', [WorkInfoController::class, 'index']);
Route::post('/store_work', [WorkInfoController::class, 'store_work']);
Route::get('/summary_work', [WorkInfoController::class, 'summary_work']);
Route::get('/edit_work/{id}', [WorkInfoController::class, 'edit_work']);
Route::post('/update_work/{id}', [WorkInfoController::class, 'update_work']);

Route::get('/certificate_info', [CertificateController::class, 'index']);
Route::post('/store_certificate', [CertificateController::class, 'store_certificate']);
Route::get('/summary_certificate', [CertificateController::class, 'summary_certificate']);
Route::get('/edit_certificate/{id}', [CertificateController::class, 'edit_certificate']);
Route::post('/update_certificate/{id}', [CertificateController::class, 'update_certificate']);

Route::get('/objective_info', [ObjectiveController::class, 'index']);
Route::post('/store_objective', [ObjectiveController::class, 'store_objective']);
Route::get('/summary_objective', [ObjectiveController::class, 'summary_objective']);
Route::get('/edit_objective/{id}', [ObjectiveController::class, 'edit_objective']);
Route::post('/update_objective/{id}', [ObjectiveController::class, 'update_objective']);

Route::get('pdf_display', [PdfController::class, 'index']);
Route::get('pdf_download', [PdfController::class, 'download']);
