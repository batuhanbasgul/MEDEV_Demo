<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CorporationController;
use App\Http\Controllers\CorporationDepartmentController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DeviceTransactionController;
use App\Http\Controllers\DataOutputController;
use App\Http\Controllers\SpendableController;
use App\Http\Controllers\EmailController;
use App\Http\Middleware\CompanyInfoMiddleware;
use App\Http\Middleware\Notification;
use App\Http\Middleware\Maintenance;
use App\Http\Middleware\PassiveUser;
use App\Models\Setting;

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
Auth::routes();
/**
 * MAINTENANCE PAGE
 */
Route::get('/maintenance', function () {
    return view('maintenance',[
        'date' => Setting::first()->date
    ]);
})->name('maintenance');

/**
 * PASSIVE USER PAGE
 */
Route::get('/user-passive', function () {
    return view('user-passive');
})->name('user-passive');

Route::middleware([Maintenance::class])->group(function () {
    Route::middleware([PassiveUser::class])->group(function () {
        Route::middleware([Notification::class])->group(function() {
            Route::middleware([CompanyInfoMiddleware::class])->group(function() {

                Route::get('/instructions', [HomeController::class, 'instructions'])->name('instructions');
                Route::get('/change-language/{langCode}', [HomeController::class, 'changeLang'])->name('change-language');
                Route::resource('/', HomeController::class)
                    ->only(['index']);

                Route::resource('user-controller',UserController::class)
                    ->only(['index','create','store','edit','update']);

                Route::resource('message-controller',MessageController::class)
                    ->only(['index','show','create','store','edit','update']);

                //Needs another form on resource, this way does not.
                Route::get('job-controller/destroy/{id}', [JobController::class, 'destroy'])->name('job-controller.destroy');
                Route::get('job-controller/my-jobs', [JobController::class, 'myJobs'])->name('job-controller.my-jobs');
                Route::resource('job-controller',JobController::class)
                ->only(['index','show','create','store','edit','update']);

                Route::get('corporation-controller/download/{id}', [CorporationController::class, 'download'])->name('corporation-controller.download');
                Route::resource('corporation-controller',CorporationController::class)
                    ->only(['index','show','create','store','edit','update']);

                //Needs another form on resource, this way does not.
                Route::get('department-controller/destroy/{id}', [CorporationDepartmentController::class, 'destroy'])->name('department-controller.destroy');
                Route::get('department-controller/download/{id}', [CorporationDepartmentController::class, 'download'])->name('department-controller.download');
                Route::resource('department-controller',CorporationDepartmentController::class)
                    ->only(['index','show','create','store','edit','update']);

                Route::get('product-controller/download-qr/{id}/{select}', [ProductController::class, 'downloadQR'])->name('product-controller.download-qr');
                Route::resource('product-controller',ProductController::class)
                    ->only(['index','show','create','store','edit','update']);

                Route::get('device-controller/add-drop/{id}', [DeviceController::class, 'addDrop'])->name('device-controller.add-drop');
                Route::post('device-controller/add-drop-save', [DeviceController::class, 'addDropSave'])->name('device-controller.add-drop-save');
                Route::resource('device-controller',DeviceController::class)
                    ->only(['index','show','create','store','edit','update']);


                //Needs another form on resource, this way does not.
                Route::get('dev-transaction-controller/download-form/{id}/{select}', [DeviceTransactionController::class, 'downloadForm'])->name('dev-transaction-controller.download-form');
                Route::get('dev-transaction-controller/destroy/{id}', [DeviceTransactionController::class, 'destroy'])->name('dev-transaction-controller.destroy');
                Route::get('dev-transaction-controller/find-devices', [DeviceTransactionController::class, 'findDevices'])->name('dev-transaction-controller.find-devices');
                Route::post('dev-transaction-controller/fetch-devices', [DeviceTransactionController::class, 'fetchDevices'])->name('dev-transaction-controller.fetch-devices');
                Route::get('dev-transaction-controller/transact-device-qr/{qrCode}', [DeviceTransactionController::class, 'transactDeviceQR'])->name('dev-transaction-controller.transact-device-qr');
                Route::get('dev-transaction-controller/transact-device/{id}', [DeviceTransactionController::class, 'transactDevice'])->name('dev-transaction-controller.transact-device');
                Route::post('dev-transaction-controller/transact-device-save', [DeviceTransactionController::class, 'transactDeviceSave'])->name('dev-transaction-controller.transact-device-save');
                Route::get('dev-transaction-controller/verify-transaction/{id}', [DeviceTransactionController::class, 'verifyTransaction'])->name('dev-transaction-controller.verify-transaction');
                Route::resource('dev-transaction-controller',DeviceTransactionController::class)
                    ->only(['index','show','create','store','edit','update']);


                Route::resource('data-output-controller',DataOutputController::class)
                ->only(['index','create','store']);
                /*
                Route::resource('spendable-controller',SpendableController::class)
                    ->only(['index','show','create','store','edit','update']);
                */

                //MAIL ROUTES
                Route::get('send-job-mail/{job_id}', [EmailController::class, 'sendJobMail'])->name('send-job-mail');
            });
            Route::resource('company-controller',CompanyController::class)
            ->only(['create','store','edit','update']);
        });
    });
});
Route::post('password-reset-mail', [EmailController::class, 'passwordResetMail'])->name('reset-password-mail');
