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
use App\Http\Controllers\Export_FtthIBController;
use App\Http\Controllers\FatController;
use App\Http\Controllers\Import_AbsensiController;
use App\Http\Controllers\ImportexcelController;
use App\Http\Controllers\ImportFtthDismantleTempController;
use App\Http\Controllers\ImportFtthIbSortirController;
use App\Http\Controllers\ImportFtthIbTempController;
use App\Http\Controllers\ImportFtthMtSortirController;
use App\Http\Controllers\ImportFtthMtTempController;
use App\Http\Controllers\ImportFttxIbTempController;
use App\Http\Controllers\ImportFttxMtTempController;
use App\Http\Controllers\KaryawanImportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitMtFtthController;
use App\Http\Controllers\PeminjamanAsetController;
use App\Http\Controllers\PengembalianAsetController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\Report_DashboardController;
use App\Http\Controllers\report_DashTrendWOController;
use App\Http\Controllers\Report_DismantleController;
use App\Http\Controllers\Report_FATController;
use App\Http\Controllers\Report_FttxIBController;
use App\Http\Controllers\Report_FttxMTController;
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

        Route::get('/portal',[PortalController::class, 'index'])->name('portal.index');

        Route::get('reportDashboard',[Report_DashboardController::class, 'index'])->name('report.dashboard');

        //*****Start Dashboard Trend WO IKR */
        Route::get('reportTrendWOIkr',[report_DashTrendWOController::class, 'index'])->name('report.reportTrendWOIkr');
        Route::get('getTrendMonthlyMT',[report_DashTrendWOController::class, 'getTrendMonthlyMT'])->name('getTrendMonthlyMT');
        Route::get('getTrendMonthlyIB',[report_DashTrendWOController::class, 'getTrendMonthlyIB'])->name('getTrendMonthlyIB');
        Route::get('getTrendMonthlyDismantle',[report_DashTrendWOController::class, 'getTrendMonthlyDismantle'])->name('getTrendMonthlyDismantle');
        Route::get('getTrendMonthlyFttxIB',[report_DashTrendWOController::class, 'getTrendMonthlyFttxIB'])->name('getTrendMonthlyFttxIB');
        Route::get('getTrendMonthlyFttxMT',[report_DashTrendWOController::class, 'getTrendMonthlyFttxMT'])->name('getTrendMonthlyFttxMT');


        //*****End Dashboard Trend WO IKR */

        //=====Start Import MT FTTH======//

        Route::get('/portal',[PortalController::class, 'index'])->name('portal.index');
        // Route::get('/', [Report_IBController::class, 'index'])->name('reportIBFtth.index');
        Route::get('/',[Report_DashboardController::class, 'index'])->name('report.dashboard');
        Route::get('reportDashboard',[Report_DashboardController::class, 'index'])->name('report.dashboard')->middleware('auth');

        Route::get('/reportMtFtth', [ReportController::class, 'index'])->name('reportMtFtth.index')->middleware('auth');
        
        Route::get('/getFilterBranch', [ReportController::class, 'getFilterBranch'])->name('getFilterBranch')->middleware('auth');
        Route::get('/getFilterDashboard', [ReportController::class, 'getFilterDashboard'])->name('getFilterDashboard')->middleware('auth');
        Route::get('/getFilterSite', [ReportController::class, 'getFilterSite'])->name('getFilterSite')->middleware('auth');
        
        Route::get('/getMonthly', [ReportController::class, 'getMonthly'])->name('getMonthly')->middleware('auth');
        Route::get('/getTotalWoBranch', [ReportController::class, 'getTotalWoBranch'])->name('getTotalWoBranch')->middleware('auth');
        Route::get('/getClusterBranch', [ReportController::class, 'getClusterBranch'])->name('getClusterBranch')->middleware('auth');

        Route::get('/getClusterBranchtest', [ReportController::class, 'getClusterBranchtest'])->name('getClusterBranchtest')->middleware('auth');

        Route::get('/getTabelStatus', [ReportController::class, 'getTabelStatus'])->name('getTabelStatus')->middleware('auth');
        Route::get('/getTrendMonthly', [ReportController::class, 'getTrendMonthly'])->name('getTrendMonthly')->middleware('auth');
        Route::get('/getRootCouseDone', [ReportController::class, 'getRootCouseDone'])->name('getRootCouseDone')->middleware('auth');
        Route::get('/getRootCousePending', [ReportController::class, 'getRootCousePending'])->name('getRootCousePending')->middleware('auth');
        Route::get('/getRootCousePendingGraph', [ReportController::class, 'getRootCousePendingGraph'])->name('getRootCousePendingGraph')->middleware('auth');
        Route::get('/getRootCouseCancel', [ReportController::class, 'getRootCouseCancel'])->name('getRootCouseCancel')->middleware('auth');
        Route::get('/getRootCouseCancelGraph', [ReportController::class, 'getRootCouseCancelGraph'])->name('getRootCouseCancelGraph')->middleware('auth');
        Route::get('/getRootCouseAPK', [ReportController::class, 'getRootCouseAPK'])->name('getRootCouseAPK')->middleware('auth');

        Route::get('/getDetailAPK', [ReportController::class, 'getDetailAPK'])->name('getDetailAPK')->middleware('auth');
        Route::get('/dataDetailAPK', [ReportController::class, 'dataDetailAPK'])->name('dataDetailAPK')->middleware('auth');
        Route::get('/getDetailAPKCluster', [ReportController::class, 'getDetailAPKCluster'])->name('getDetailAPKCluster')->middleware('auth');

        Route::get('/getRootCouseAPKGraph', [ReportController::class, 'getRootCouseAPKGraph'])->name('getRootCouseAPKGraph')->middleware('auth');
        Route::get('/getCancelSystemProblem', [ReportController::class, 'getCancelSystemProblem'])->name('getCancelSystemProblem')->middleware('auth');
        Route::get('/getAnalisPrecon', [ReportController::class, 'getAnalisPrecon'])->name('getAnalisPrecon')->middleware('auth');

        
        Route::get('/getTrendMonthlyApart', [ReportController::class, 'getTrendMonthlyApart'])->name('getTrendMonthlyApart')->middleware('auth');
        Route::get('/getTabelStatusApart', [ReportController::class, 'getTabelStatusApart'])->name('getTabelStatusApart')->middleware('auth');
        Route::get('/getRootCouseDoneApart', [ReportController::class, 'getRootCouseDoneApart'])->name('getRootCouseDoneApart')->middleware('auth');
        Route::get('/getRootCouseAPKApart', [ReportController::class, 'getRootCouseAPKApart'])->name('getRootCouseAPKApart')->middleware('auth');
        Route::get('/getRootCousePendingApart', [ReportController::class, 'getRootCousePendingApart'])->name('getRootCousePendingApart')->middleware('auth');
        Route::get('/getRootCouseCancelApart', [ReportController::class, 'getRootCouseCancelApart'])->name('getRootCouseCancelApart')->middleware('auth');
        
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

        Route::get('/importftthmtsortir', [ImportFtthMtSortirController::class , 'index'])->name('import.ftthmtsortirIndex');
        Route::post('/import-FtthMtsortir', [ImportFtthMtSortirController::class, 'importFtthMtSortir'])->name('import.ImportFtthMtSortir');

        Route::get('/getFilterSummary',[ImportFtthMtTempController::class, 'getFilterSummary'])->name('getFilterSummary');

        Route::post('/saveImportMtFtth', [ImportFtthMtTempController::class, 'saveImportFtthMt'])->name('saveImportMtFtth');

        //=====End Import MT FTTH======//

        //=====Start Import IB FTTH======//
        Route::get('/importftthIBtemp', [ImportFtthIbTempController::class , 'index'])->name('import.ftthIBtempIndex');
        Route::post('/DataImportFtthIBTemp', [ImportFtthIbTempController::class, 'dataImportFtthIBTemp'])->name('import.dataImportFtthIBTemp');
        Route::post('/import-FtthIBTemp', [ImportFtthIbTempController::class, 'importFtthIBTemp'])->name('import.ImportFtthIBTemp');

        Route::get('/importftthIBSortir', [ImportFtthIbSortirController::class , 'index'])->name('import.ftthIBSortirIndex');
        Route::post('/import-FtthIBSortir', [ImportFtthIbSortirController::class, 'importFtthIBSortir'])->name('import.ImportFtthIBSortir');


        Route::get('/getFilterSummaryIB',[ImportFtthIbTempController::class, 'getFilterSummaryIB'])->name('getFilterSummaryIB');

        Route::post('/saveImportIbFtth', [ImportFtthIbTempController::class, 'saveImportFtthIb'])->name('saveImportIbFtth');
        //=====End Import IB FTTH======//

        //====Start Report IB FTTH====//

        Route::get('/reportIBFtth', [Report_IBController::class, 'index'])->name('reportIBFtth.index')->middleware('auth');
        Route::get('/getFilterBranchIBFtth', [Report_IBController::class, 'getFilterBranchIBFtth'])->name('getFilterBranchIBFtth')->middleware('auth');
        Route::get('/getTotalWoBranchIBFtth', [Report_IBController::class, 'getTotalWoBranchIBFtth'])->name('getTotalWoBranchIBFtth')->middleware('auth');
        Route::get('/getFilterDashboardIBFtth', [Report_IBController::class, 'getFilterDashboardIBFtth'])->name('getFilterDashboardIBFtth')->middleware('auth');

        Route::get('/getMonthlyIBFtth', [Report_IBController::class, 'getMonthlyIBFtth'])->name('getMonthlyIBFtth')->middleware('auth');

        Route::get('/getDetailAPKIb', [Report_IBController::class, 'getDetailAPKIb'])->name('getDetailAPKIb')->middleware('auth');
        Route::get('/dataDetailAPKIb', [Report_IBController::class, 'dataDetailAPKIb'])->name('dataDetailAPKIb')->middleware('auth');
        Route::get('/getDetailAPKIbCluster', [Report_IBController::class, 'getDetailAPKIbCluster'])->name('getDetailAPKIbCluster')->middleware('auth');

        Route::get('/getFilterDashboardIBFtthOld', [Report_IBController::class, 'getFilterDashboardIBFtthOld'])->name('getFilterDashboardIBFtthOld')->middleware('auth');

        Route::get('/getTrendMonthlyIBFtth', [Report_IBController::class, 'getTrendMonthlyIBFtth'])->name('getTrendMonthlyIBFtth')->middleware('auth');
        Route::get('/getTabelStatusIBFtth', [Report_IBController::class, 'getTabelStatusIBFtth'])->name('getTabelStatusIBFtth')->middleware('auth');

        Route::get('/getReasonStatusIBFtthGraph', [Report_IBController::class, 'getReasonStatusIBFtthGraph'])->name('getReasonStatusIBFtthGraph')->middleware('auth');
        Route::get('/getRootCouseAPKIBFtth', [Report_IBController::class, 'getRootCouseAPKIBFtth'])->name('getRootCouseAPKIBFtth')->middleware('auth');

        Route::get('/getRootCousePendingGraphIBFtth', [Report_IBController::class, 'getRootCousePendingGraphIBFtth'])->name('getRootCousePendingGraphIBFtth')->middleware('auth');
        Route::get('/getRootCousePendingIBFtth', [Report_IBController::class, 'getRootCousePendingIBFtth'])->name('getRootCousePendingIBFtth')->middleware('auth');

        Route::get('/getRootCouseCancelGraphIBFtth', [Report_IBController::class, 'getRootCouseCancelGraphIBFtth'])->name('getRootCouseCancelGraphIBFtth')->middleware('auth');
        Route::get('/getRootCouseCancelIBFtth', [Report_IBController::class, 'getRootCouseCancelIBFtth'])->name('getRootCouseCancelIBFtth')->middleware('auth');

        Route::get('/getClusterBranchIBFtth', [Report_IBController::class, 'getClusterBranchIBFtth'])->name('getClusterBranchIBFtth')->middleware('auth');

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

       Route::get('/getMonthlyDismantle', [Report_DismantleController::class, 'getMonthlyDismantle'])->name('getMonthlyDismantle');

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

       Route::get('/getDetailAPKDismantle', [Report_DismantleController::class, 'getDetailAPKDismantle'])->name('getDetailAPKDismantle')->middleware('auth');
       Route::get('/dataDetailAPKDismantle', [Report_DismantleController::class, 'dataDetailAPKDismantle'])->name('dataDetailAPKDismantle')->middleware('auth');
       Route::get('/getDetailAPKDismantleCluster', [Report_DismantleController::class, 'getDetailAPKDismantleCluster'])->name('getDetailAPKDismantleCluster')->middleware('auth');

    //    Route::get('/getRootCouseCancelGraphIBFtth', [Report_IBController::class, 'getRootCouseCancelGraphIBFtth'])->name('getRootCouseCancelGraphIBFtth');
    //    Route::get('/getRootCouseCancelIBFtth', [Report_IBController::class, 'getRootCouseCancelIBFtth'])->name('getRootCouseCancelIBFtth');

      //====End Report Dismantle FTTH====//


      //=====Start Import FTTX MT======//
      Route::get('/importfttxMTtemp', [ImportFttxMtTempController::class , 'index'])->name('import.fttxMTtempIndex');
      Route::post('/DataImportFttxMTTemp', [ImportFttxMtTempController::class, 'dataImportFttxMTTemp'])->name('import.dataImportFttxMTTemp');
      Route::post('/import-FttxMTTemp', [ImportFttxMtTempController::class, 'importFttxMTTemp'])->name('import.ImportFttxMTTemp');

      Route::get('/getFilterSummaryFttxMT',[ImportFttxMtTempController::class, 'getFilterSummaryFttxMT'])->name('getFilterSummaryFttxMT');

      Route::post('/saveImportFttxMt', [ImportFttxMtTempController::class, 'saveImportFttxMT'])->name('saveImportFttxMT');
      //=====End Import MTTX MT======//


      //=====Start Import FTTX IB======//
      Route::get('/importfttxIBtemp', [ImportFttxIbTempController::class , 'index'])->name('import.fttxIBtempIndex');
      Route::post('/DataImportFttxIBTemp', [ImportFttxIbTempController::class, 'dataImportFttxIBTemp'])->name('import.dataImportFttxIBTemp');
      Route::post('/import-FttxIBTemp', [ImportFttxIbTempController::class, 'importFttxIBTemp'])->name('import.ImportFttxIBTemp');

      Route::get('/getFilterSummaryFttxIB',[ImportFttxIbTempController::class, 'getFilterSummaryFttxIB'])->name('getFilterSummaryFttxIB');

      Route::post('/saveImportFttxIB', [ImportFttxIbTempController::class, 'saveImportFttxIB'])->name('saveImportFttxIB');
      //=====End Import FTTX IB======//


      //====Start Report FTTX MT====//

      Route::get('/reportMTFttx', [Report_FttxMTController::class, 'index'])->name('reportMTFttx.index');
      Route::get('/getFilterBranchMTFttx', [Report_FttxMTController::class, 'getFilterBranchMTFttx'])->name('getFilterBranchMTFttx');
      Route::get('/getTotalWoBranchMTFttx', [Report_FttxMTController::class, 'getTotalWoBranchMTFttx'])->name('getTotalWoBranchMTFttx');
      Route::get('/getFilterDashboardMTFttx', [Report_FttxMTController::class, 'getFilterDashboardMTFttx'])->name('getFilterDashboardMTFttx');

      Route::get('/getTrendMonthlyMTFttx', [Report_FttxMTController::class, 'getTrendMonthlyMTFttx'])->name('getTrendMonthlyMTFttx');
      Route::get('/getTabelStatusMTFttx', [Report_FttxMTController::class, 'getTabelStatusMTFttx'])->name('getTabelStatusMTFttx');

      Route::get('/getReasonStatusMTFttxGraph', [Report_FttxMTController::class, 'getReasonStatusMTFttxGraph'])->name('getReasonStatusMTFttxGraph');
      Route::get('/getRootCouseAPKMTFttx', [Report_FttxMTController::class, 'getRootCouseAPKMTFttx'])->name('getRootCouseAPKMTFttx');
      Route::get('/getRootCouseAPKMTFttxDetail', [Report_FttxMTController::class, 'getRootCouseAPKMTFttxDetail'])->name('getRootCouseAPKMTFttxDetail');

      Route::get('/getRootCousePendingGraphMTFttx', [Report_FttxMTController::class, 'getRootCousePendingGraphMTFttx'])->name('getRootCousePendingGraphMTFttx');
      Route::get('/getRootCousePendingMTFttx', [Report_FttxMTController::class, 'getRootCousePendingMTFttx'])->name('getRootCousePendingMTFttx');

      Route::get('/getRootCouseCancelGraphMTFttx', [Report_FttxMTController::class, 'getRootCouseCancelGraphMTFttx'])->name('getRootCouseCancelGraphMTFttx');
      Route::get('/getRootCouseCancelMTFttx', [Report_FttxMTController::class, 'getRootCouseCancelMTFttx'])->name('getRootCouseCancelMTFttx');

      Route::get('/getClusterBranchMTFttx', [Report_FttxMTController::class, 'getClusterBranchMTFttx'])->name('getClusterBranchMTFttx');

      Route::get('/getDetailAPKMtFttx', [Report_FttxMTController::class, 'getDetailAPKMtFttx'])->name('getDetailAPKMtFttx')->middleware('auth');
      Route::get('/dataDetailAPKMtFttx', [Report_FttxMTController::class, 'dataDetailAPKMtFttx'])->name('dataDetailAPKMtFttx')->middleware('auth');
      Route::get('/getDetailAPKMtFttxCluster', [Report_FttxMTController::class, 'getDetailAPKMtFttxCluster'])->name('getDetailAPKMtFttxCluster')->middleware('auth');

     //====End Report FTTX MT====//

     //====Start Report FTTX IB====//

     Route::get('/reportIBFttx', [Report_FttxIBController::class, 'index'])->name('reportIBFttx.index');
     Route::get('/getFilterBranchIBFttx', [Report_FttxIBController::class, 'getFilterBranchIBFttx'])->name('getFilterBranchIBFttx');
     Route::get('/getTotalWoBranchIBFttx', [Report_FttxIBController::class, 'getTotalWoBranchIBFttx'])->name('getTotalWoBranchIBFttx');
     Route::get('/getFilterDashboardIBFttx', [Report_FttxIBController::class, 'getFilterDashboardIBFttx'])->name('getFilterDashboardIBFttx');

     Route::get('/getTrendMonthlyIBFttx', [Report_FttxIBController::class, 'getTrendMonthlyIBFttx'])->name('getTrendMonthlyIBFttx');
     Route::get('/getTabelStatusIBFttx', [Report_FttxIBController::class, 'getTabelStatusIBFttx'])->name('getTabelStatusIBFttx');

     Route::get('/getReasonStatusIBFttxGraph', [Report_FttxIBController::class, 'getReasonStatusIBFttxGraph'])->name('getReasonStatusIBFttxGraph');
     Route::get('/getRootCouseAPKIBFttx', [Report_FttxIBController::class, 'getRootCouseAPKIBFttx'])->name('getRootCouseAPKIBFttx');

     Route::get('/getRootCousePendingGraphIBFttx', [Report_FttxIBController::class, 'getRootCousePendingGraphIBFttx'])->name('getRootCousePendingGraphIBFttx');
     Route::get('/getRootCousePendingIBFttx', [Report_FttxIBController::class, 'getRootCousePendingIBFttx'])->name('getRootCousePendingIBFttx');

     Route::get('/getRootCouseCancelGraphIBFttx', [Report_FttxIBController::class, 'getRootCouseCancelGraphIBFttx'])->name('getRootCouseCancelGraphIBFttx');
     Route::get('/getRootCouseCancelIBFttx', [Report_FttxIBController::class, 'getRootCouseCancelIBFttx'])->name('getRootCouseCancelIBFttx');

     Route::get('/getClusterBranchIBFttx', [Report_FttxIBController::class, 'getClusterBranchIBFttx'])->name('getClusterBranchIBFttx');

     Route::get('/getDetailAPKIbFttx', [Report_FttxIBController::class, 'getDetailAPKIbFttx'])->name('getDetailAPKIbFttx')->middleware('auth');
     Route::get('/dataDetailAPKIbFttx', [Report_FttxIBController::class, 'dataDetailAPKIbFttx'])->name('dataDetailAPKIbFttx')->middleware('auth');
     Route::get('/getDetailAPKIbFttxCluster', [Report_FttxIBController::class, 'getDetailAPKIbFttxCluster'])->name('getDetailAPKIbFttxCluster')->middleware('auth');

    //====End Report FTTX IB====//

    //====Start Import Absensi===//
    
    Route::get('/importAbsensi', [Import_AbsensiController::class, 'index'])->name('importAbsensi.index');

    //===End Import Absensi===//


    //===Start Report FAT===//

    Route::get('/reportFat',[Report_FATController::class, 'index'])->name('reportFat.index');

    Route::get('/getBranchFat', [Report_FATController::class, 'getBranchFat'])->name('getBranchFat');
    Route::get('/getDetailFAT', [Report_FATController::class, 'getDetailFAT'])->name('getDetailFAT');
    Route::get('/dataDetailFAT', [Report_FATController::class, 'dataDetailFAT'])->name('dataDetailFAT');

    //===End Report FAT===//

    //===Start Download Export===//

    Route::get('/exportData',[Export_FtthIBController::class, 'export'])->name('exportData');

    //===End Download Export===//
    
    }

    
);