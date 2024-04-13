<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\JoblistingController;
use App\Http\Controllers\PostJobController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\IsPremiumUser;
use App\Http\Middleware\IsSeeker;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

Route::get('/', [JoblistingController::class, 'index'])->name('listing.index');

Route::get('/company/{id}', [JoblistingController::class, 'company'])->name('company');

Route::get('/jobs/{listing:slug}', [JoblistingController::class, 'show'])->name('job.show');

Route::post('/resume/upload', [FileUploadController::class, 'store'])->middleware('auth');

Route::get('/register/seeker', [UserController::class, 'createSeeker'])->name('create.seeker')->middleware(AuthCheck::class);

Route::post('/register/seeker', [UserController::class, 'storeSeeker'])->name('store.seeker');

Route::get('/register/employer', [UserController::class, 'createEmployer'])->name('create.employer')->middleware(AuthCheck::class);

Route::post('/register/employer', [UserController::class, 'storeEmployer'])->name('store.employer');

Route::get('/login', [UserController::class, 'login'])->name('login')->middleware(AuthCheck::class);

Route::post('/login', [UserController::class, 'postLogin'])->name('login.post');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/user/editemployer', [UserController::class, 'editemployer'])->name('user.editemployer')->middleware('auth');

Route::post('/user/update', [UserController::class, 'update'])->name('user.update')->middleware('auth');

Route::get('/user/editseeker', [UserController::class, 'editseeker'])->name('user.editseeker')->middleware('auth');

Route::get('/user/jobsapplied', [UserController::class, 'jobsApplied'])->name('user.jobsapplied')->middleware('auth');

Route::get('/user/changePassword', [UserController::class, 'editPassword'])->name('user.editPassword');

Route::post('/user/changePassword', [UserController::class, 'updatePassword'])->name('user.updatePassword');

Route::get('/user/uploadresume', [UserController::class, 'editResume'])->name('user.editResume')->middleware(IsSeeker::class);

Route::post('/user/updateresume', [UserController::class, 'updateResume'])->name('user.updateResume')->middleware(IsSeeker::class);

// when user login, redirect to dashboard
// middleware checks if user is verified or not
// if verified then redirects to dashboard
// else redirects to verification.notice
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified', IsPremiumUser::class])->name('dashboard');

Route::get('/verify', [DashboardController::class, 'verify'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/resend/verification/email', [DashboardController::class, 'resend'])->name('resend.email');

Route::get('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');

Route::get('/pay/weekly', [SubscriptionController::class, 'initiatePayment'])->name('pay.weekly');

Route::get('/pay/monthly', [SubscriptionController::class, 'initiatePayment'])->name('pay.monthly');

Route::get('/pay/yearly', [SubscriptionController::class, 'initiatePayment'])->name('pay.yearly');

Route::get('/pay/success', [SubscriptionController::class, 'paymentSuccess'])->name('pay.success');

Route::get('/pay/cancel', [SubscriptionController::class, 'paymentCancel'])->name('pay.cancel');

Route::get('/job/create', [PostJobController::class, 'create'])->name('job.create');

Route::post('/job/store', [PostJobController::class, 'store'])->name('job.store');

Route::get('/job/{listing}/edit', [PostJobController::class, 'edit'])->name('job.edit');

Route::put('/job/{id}/edit', [PostJobController::class, 'update'])->name('job.update');

Route::get('/job', [PostJobController::class, 'index'])->name('job.index');

Route::delete('/job/{id}', [PostJobController::class, 'delete'])->name('job.delete');

Route::get('/applicants', [ApplicantController::class, 'index'])->name('applicants');

Route::get('/applicants/{listing:slug}', [ApplicantController::class, 'show'])->name('applicants.show');

Route::post('/shortlist/{listingId}/{userId}', [ApplicantController::class, 'shortlist'])->name('applicants.shortlist');

Route::post('/application/{listingId}/submit', [ApplicantController::class, 'apply'])->name('application.submit');
