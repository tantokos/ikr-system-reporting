<?php

use App\Http\Controllers\AsetDashController;
use App\Http\Controllers\AsetDisposalController;
use App\Http\Controllers\AsetIkrController;
use App\Http\Controllers\AsetImportTempController;
use App\Http\Controllers\BatchWOController;
use App\Http\Controllers\BatchwoController as ControllersBatchwoController;
use App\Http\Controllers\BatchwoIdxController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CallsignController;
use App\Http\Controllers\CallsignLeadController;
use App\Http\Controllers\CallsignTimController;
use App\Http\Controllers\DashWoController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeDashController;
use App\Http\Controllers\FatController;
use App\Http\Controllers\ImportexcelController;
use App\Http\Controllers\ImportFtthMtTempController;
use App\Http\Controllers\KaryawanImportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitMtFtthController;
use App\Http\Controllers\PeminjamanAsetController;
use App\Http\Controllers\PengembalianAsetController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TimDashController;
use App\Http\Controllers\WarehouseController;
use App\Models\AsetIkr;
use App\Models\CallsignTim;
use App\Models\importexcel;
use App\Models\ImportFtthMtSortirTemp;
use App\Models\MonitMTFtth;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login.proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/reg',[LoginController::class,'register'])->name('reg');
Route::post('/reg-proses',[LoginController::class,'register_prosess'])->name('register.proses');

// Route::group(['middleware' => ['web']], function () {
//     Route::get('autologin', function () {
//         $user = $_GET['id'];
//         Auth::loginUsingId($user, true);
//         return redirect()->route('report.index');
//     });
// });


Route::group(
       // ['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'],
    ['middleware' => ['auth']],
    function () {

        Route::get('/portal',[PortalController::class, 'index'])->name('portal.index');
        Route::get('/', [ReportController::class, 'index'])->name('reportMtFtth.index');
        Route::get('/getTotalWoBranch', [ReportController::class, 'getTotalWoBranch'])->name('getTotalWoBranch');
        Route::get('/getTabelStatus', [ReportController::class, 'getTabelStatus'])->name('getTabelStatus');
        Route::get('/getTrendMonthly', [ReportController::class, 'getTrendMonthly'])->name('getTrendMonthly');
        Route::get('/getRootCouseDone', [ReportController::class, 'getRootCouseDone'])->name('getRootCouseDone');
        Route::get('/getRootCousePending', [ReportController::class, 'getRootCousePending'])->name('getRootCousePending');
        Route::get('/getRootCouseCancel', [ReportController::class, 'getRootCouseCancel'])->name('getRootCouseCancel');
        Route::get('/getRootCouseAPK', [ReportController::class, 'getRootCouseAPK'])->name('getRootCouseAPK');
        Route::get('/getCancelSystemProblem', [ReportController::class, 'getCancelSystemProblem'])->name('getCancelSystemProblem');
        Route::get('/getTrendMonthlyApart', [ReportController::class, 'getTrendMonthlyApart'])->name('getTrendMonthlyApart');

        Route::get('/importftthmttemp', [ImportFtthMtTempController::class , 'index'])->name('import.ftthmttempIndex');
        Route::get('/DataImportFtthMtTemp', [ImportFtthMtTempController::class, 'dataImportFtthTemp'])->name('import.dataImportFtthMtTemp');
        Route::post('/import-FtthMtTemp', [ImportFtthMtTempController::class, 'importFtthMtTemp'])->name('import.ImportFtthMtTemp');
        Route::get('/import-SummaryTemp', [ImportFtthMtTempController::class, 'show_summary'])->name('import.summaryImportFtthMtTemp');

        Route::post('/saveImportMtFtth', [ImportFtthMtTempController::class, 'saveImportFtthMt'])->name('saveImportMtFtth');
       
    }
);
