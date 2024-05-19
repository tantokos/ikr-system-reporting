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
use App\Http\Controllers\ImportFtthDismantleTempController;
use App\Http\Controllers\ImportFtthIBTempController;
use App\Http\Controllers\ImportFtthMtTempController;
use App\Http\Controllers\KaryawanImportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitMtFtthController;
use App\Http\Controllers\PeminjamanAsetController;
use App\Http\Controllers\PengembalianAsetController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\Report_DismantleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Report_IBController;
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

        //=====Start Import MT FTTH======//

        Route::get('/portal',[PortalController::class, 'index'])->name('portal.index');
        Route::get('/', [ReportController::class, 'index'])->name('reportMtFtth.index');
        
        Route::get('/getFilterBranch', [ReportController::class, 'getFilterBranch'])->name('getFilterBranch');
        Route::get('/getFilterDashboard', [ReportController::class, 'getFilterDashboard'])->name('getFilterDashboard');
        Route::get('/getFilterSite', [ReportController::class, 'getFilterSite'])->name('getFilterSite');
        
        Route::get('/getTotalWoBranch', [ReportController::class, 'getTotalWoBranch'])->name('getTotalWoBranch');
        Route::get('/getClusterBranch', [ReportController::class, 'getClusterBranch'])->name('getClusterBranch');

        Route::get('/getTabelStatus', [ReportController::class, 'getTabelStatus'])->name('getTabelStatus');
        Route::get('/getTrendMonthly', [ReportController::class, 'getTrendMonthly'])->name('getTrendMonthly');
        Route::get('/getRootCouseDone', [ReportController::class, 'getRootCouseDone'])->name('getRootCouseDone');
        Route::get('/getRootCousePending', [ReportController::class, 'getRootCousePending'])->name('getRootCousePending');
        Route::get('/getRootCousePendingGraph', [ReportController::class, 'getRootCousePendingGraph'])->name('getRootCousePendingGraph');
        Route::get('/getRootCouseCancel', [ReportController::class, 'getRootCouseCancel'])->name('getRootCouseCancel');
        Route::get('/getRootCouseCancelGraph', [ReportController::class, 'getRootCouseCancelGraph'])->name('getRootCouseCancelGraph');
        Route::get('/getRootCouseAPK', [ReportController::class, 'getRootCouseAPK'])->name('getRootCouseAPK');
        Route::get('/getRootCouseAPKGraph', [ReportController::class, 'getRootCouseAPKGraph'])->name('getRootCouseAPKGraph');
        Route::get('/getCancelSystemProblem', [ReportController::class, 'getCancelSystemProblem'])->name('getCancelSystemProblem');
        
        Route::get('/getTrendMonthlyApart', [ReportController::class, 'getTrendMonthlyApart'])->name('getTrendMonthlyApart');
        Route::get('/getTabelStatusApart', [ReportController::class, 'getTabelStatusApart'])->name('getTabelStatusApart');
        Route::get('/getRootCouseDoneApart', [ReportController::class, 'getRootCouseDoneApart'])->name('getRootCouseDoneApart');
        Route::get('/getRootCouseAPKApart', [ReportController::class, 'getRootCouseAPKApart'])->name('getRootCouseAPKApart');
        Route::get('/getRootCousePendingApart', [ReportController::class, 'getRootCousePendingApart'])->name('getRootCousePendingApart');
        Route::get('/getRootCouseCancelApart', [ReportController::class, 'getRootCouseCancelApart'])->name('getRootCouseCancelApart');
        
        Route::get('/getTrendMonthlyUG', [ReportController::class, 'getTrendMonthlyUG'])->name('getTrendMonthlyUG');
        Route::get('/getTabelStatusUG', [ReportController::class, 'getTabelStatusUG'])->name('getTabelStatusUG');
        Route::get('/getRootCouseDoneUG', [ReportController::class, 'getRootCouseDoneUG'])->name('getRootCouseDoneUG');
        Route::get('/getRootCouseAPKUG', [ReportController::class, 'getRootCouseAPKUG'])->name('getRootCouseAPKUG');
        Route::get('/getRootCousePendingUG', [ReportController::class, 'getRootCousePendingUG'])->name('getRootCousePendingUG');
        Route::get('/getRootCouseCancelUG', [ReportController::class, 'getRootCouseCancelUG'])->name('getRootCouseCancelUG');
        
        Route::get('/importftthmttemp', [ImportFtthMtTempController::class , 'index'])->name('import.ftthmttempIndex');
        Route::post('/DataImportFtthMtTemp', [ImportFtthMtTempController::class, 'dataImportFtthTemp'])->name('import.dataImportFtthMtTemp');
        Route::post('/import-FtthMtTemp', [ImportFtthMtTempController::class, 'importFtthMtTemp'])->name('import.ImportFtthMtTemp');
        Route::get('/import-SummaryTemp', [ImportFtthMtTempController::class, 'show_summary'])->name('import.summaryImportFtthMtTemp');

        Route::get('/getFilterSummary',[ImportFtthMtTempController::class, 'getFilterSummary'])->name('getFilterSummary');

        Route::post('/saveImportMtFtth', [ImportFtthMtTempController::class, 'saveImportFtthMt'])->name('saveImportMtFtth');

        //=====End Import MT FTTH======//

        //=====Start Import IB FTTH======//
        Route::get('/importftthIBtemp', [ImportFtthIbTempController::class , 'index'])->name('import.ftthIBtempIndex');
        Route::post('/DataImportFtthIBTemp', [ImportFtthIbTempController::class, 'dataImportFtthIBTemp'])->name('import.dataImportFtthIBTemp');
        Route::post('/import-FtthIBTemp', [ImportFtthIbTempController::class, 'importFtthIBTemp'])->name('import.ImportFtthIBTemp');

        Route::get('/getFilterSummaryIB',[ImportFtthIbTempController::class, 'getFilterSummaryIB'])->name('getFilterSummaryIB');

        Route::post('/saveImportIbFtth', [ImportFtthIbTempController::class, 'saveImportFtthIb'])->name('saveImportIbFtth');
        //=====End Import IB FTTH======//

        //====Start Report IB FTTH====//

        Route::get('/reportIBFtth', [Report_IBController::class, 'index'])->name('reportIBFtth.index');
        Route::get('/getFilterBranchIBFtth', [Report_IBController::class, 'getFilterBranchIBFtth'])->name('getFilterBranchIBFtth');
        Route::get('/getTotalWoBranchIBFtth', [Report_IBController::class, 'getTotalWoBranchIBFtth'])->name('getTotalWoBranchIBFtth');
        Route::get('/getFilterDashboardIBFtth', [Report_IBController::class, 'getFilterDashboardIBFtth'])->name('getFilterDashboardIBFtth');

        Route::get('/getTrendMonthlyIBFtth', [Report_IBController::class, 'getTrendMonthlyIBFtth'])->name('getTrendMonthlyIBFtth');
        Route::get('/getTabelStatusIBFtth', [Report_IBController::class, 'getTabelStatusIBFtth'])->name('getTabelStatusIBFtth');

        Route::get('/getReasonStatusIBFtthGraph', [Report_IBController::class, 'getReasonStatusIBFtthGraph'])->name('getReasonStatusIBFtthGraph');
        Route::get('/getRootCouseAPKIBFtth', [Report_IBController::class, 'getRootCouseAPKIBFtth'])->name('getRootCouseAPKIBFtth');

        Route::get('/getRootCousePendingGraphIBFtth', [Report_IBController::class, 'getRootCousePendingGraphIBFtth'])->name('getRootCousePendingGraphIBFtth');
        Route::get('/getRootCousePendingIBFtth', [Report_IBController::class, 'getRootCousePendingIBFtth'])->name('getRootCousePendingIBFtth');

        Route::get('/getRootCouseCancelGraphIBFtth', [Report_IBController::class, 'getRootCouseCancelGraphIBFtth'])->name('getRootCouseCancelGraphIBFtth');
        Route::get('/getRootCouseCancelIBFtth', [Report_IBController::class, 'getRootCouseCancelIBFtth'])->name('getRootCouseCancelIBFtth');

        Route::get('/getClusterBranchIBFtth', [Report_IBController::class, 'getClusterBranchIBFtth'])->name('getClusterBranchIBFtth');

       //====End Report IB FTTH====//

       //=====Start Import Dismantle FTTH======//
       Route::get('/importftthDismantletemp', [ImportFtthDismantleTempController::class , 'index'])->name('import.ftthDismantletempIndex');
       Route::post('/DataImportFtthDismantleTemp', [ImportFtthDismantleTempController::class, 'dataImportFtthDismantleTemp'])->name('import.dataImportFtthDismantleTemp');
       Route::post('/import-FtthDismantleTemp', [ImportFtthDismantleTempController::class, 'importFtthDismantleTemp'])->name('import.ImportFtthDismantleTemp');

       Route::get('/getFilterSummaryDismantle',[ImportFtthDismantleTempController::class, 'getFilterSummaryDismantle'])->name('getFilterSummaryDismantle');

       Route::post('/saveImportDismantleFtth', [ImportFtthDismantleTempController::class, 'saveImportFtthDismantle'])->name('saveImportDismantleFtth');
       //=====End Import Dismantle FTTH======//


       //====Start Report Dismantle FTTH====//

       Route::get('/reportDismantleFtth', [Report_DismantleController::class, 'index'])->name('reportDismantleFtth.index');

       Route::get('/getFilterBranchDismantleFtth', [Report_DismantleController::class, 'getFilterBranchDismantleFtth'])->name('getFilterBranchDismantleFtth');
       Route::get('/getTotalWoBranchDismantleFtth', [Report_DismantleController::class, 'getTotalWoBranchDismantleFtth'])->name('getTotalWoBranchDismantleFtth');

       Route::get('/getFilterDashboardDismantleFtth', [Report_DismantleController::class, 'getFilterDashboardDismantleFtth'])->name('getFilterDashboardDismantleFtth');

       Route::get('/getTrendMonthlyDismantleFtth', [Report_DismantleController::class, 'getTrendMonthlyDismantleFtth'])->name('getTrendMonthlyDismantleFtth');
       Route::get('/getTabelStatusDismantleFtth', [Report_DismantleController::class, 'getTabelStatusDismantleFtth'])->name('getTabelStatusDismantleFtth');

       Route::get('/getClusterBranchDismantleFtth', [Report_DismantleController::class, 'getClusterBranchDismantleFtth'])->name('getClusterBranchDismantleFtth');
       Route::get('/getRootCouseAPKDismantleFtth', [Report_DismantleController::class, 'getRootCouseAPKDismantleFtth'])->name('getRootCouseAPKDismantleFtth');

       Route::get('/getReasonStatusDismantleFtthGraph', [Report_DismantleController::class, 'getReasonStatusDismantleFtthGraph'])->name('getReasonStatusDismantleFtthGraph');

       Route::get('/getRootCouseAPKDismantleFtth', [Report_DismantleController::class, 'getRootCouseAPKDismantleFtth'])->name('getRootCouseAPKDismantleFtth');

       Route::get('/getRootCousePendingGraphDismantleFtth', [Report_DismantleController::class, 'getRootCousePendingGraphDismantleFtth'])->name('getRootCousePendingGraphDismantleFtth');
       Route::get('/getRootCousePendingDismantleFtth', [Report_DismantleController::class, 'getRootCousePendingDismantleFtth'])->name('getRootCousePendingDismantleFtth');

       Route::get('/getRootCouseCancelGraphIBFtth', [Report_IBController::class, 'getRootCouseCancelGraphIBFtth'])->name('getRootCouseCancelGraphIBFtth');
       Route::get('/getRootCouseCancelIBFtth', [Report_IBController::class, 'getRootCouseCancelIBFtth'])->name('getRootCouseCancelIBFtth');

       

      //====End Report Dismantle FTTH====//
    }
);
