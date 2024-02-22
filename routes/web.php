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
use App\Http\Controllers\KaryawanImportController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitMtFtthController;
use App\Http\Controllers\PeminjamanAsetController;
use App\Http\Controllers\PengembalianAsetController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\TimDashController;
use App\Http\Controllers\WarehouseController;
use App\Models\AsetIkr;
use App\Models\CallsignTim;
use App\Models\importexcel;
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

Route::group(['middleware' => ['web']], function () {
    Route::get('autologin', function () {
        $user = $_GET['id'];
        Auth::loginUsingId($user, true);
        return redirect()->route('aset.index');
    });
});


Route::group(
       // ['prefix' => 'admin', 'middleware' => ['auth'], 'as' => 'admin.'],
    ['middleware' => ['auth']],
    function () {
        // Route::get('/autologin', function () {
        //     $user = $_GET['id'];
        //     Auth::loginUsingId($user, true);
        //     return redirect()->intended('aset.index');
        // });
        Route::get('/portal',[PortalController::class, 'index'])->name('portal.index');
        Route::get('/', [AsetDashController::class, 'index'])->name('aset.index');
        // Route::get('/employee',[EmployeeController::class,'index']);
        Route::get('/employeedata', [EmployeeController::class, 'employeeData'])->name('employee.data');
        Route::get('/employeeCreate', [EmployeeController::class, 'create']);
        // Route::get('/employeeEdit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::get('/employeeDetail/{id}', [EmployeeController::class, 'detail'])->name('employee.detail');
        Route::get('/employeeDetail2/{id}', [EmployeeController::class, 'detail2'])->name('employee.detail2');
        Route::resource('employee', EmployeeController::class);

        Route::get('/branch', [BranchController::class, 'index'])->name('branch.index');
        Route::get('/branchdata', [BranchController::class, 'dataTable'])->name('branch.data');
        Route::get('/branchCreate', [BranchController::class, 'create'])->name('branch.create');
        Route::get('/branchEdit/{id}', [BranchController::class, 'edit'])->name('branch.edit');
        // Route::resource('branch', BranchController::class);

        Route::get('/callsignLeadIndex', [CallsignLeadController::class, 'index'])->name('callsignLead.index');
        Route::get('/callsignLeaddata', [CallsignLeadController::class, 'dataCallsignLead'])->name('callsignLead.data');
        Route::get('/callsignLeadCreate', [CallsignLeadController::class, 'create'])->name('callsignLead.create');
        Route::get('/callsignLeadShow/{leaderid}', [CallsignLeadController::class, 'show'])->name('callsignLead.show');
        Route::get('/callsignLeadEdit/{id}', [CallsignLeadController::class, 'edit'])->name('callsignLead.edit');
        // Route::get('/callsignLeadUpd/{id}',CallsignLeadController::class,'update')->name('callsignLeadUpd.update');
        // Route::resource('callsignLead', CallsignLeadController::class);

        Route::get('/callsignTim',[CallsignTimController::class, 'index'])->name('callsignTim.index');
        Route::get('/callsignTimShow/{leaderid}', [CallsignTimController::class, 'show'])->name('callsignTimShow.show');
        Route::get('/callsignTimEdit/{timID}', [CallsignTimController::class, 'edit'])->name('callsignTim.edit');
        Route::get('/callsignTimCreate',[CallsignTimController::class,'create'])->name('callsignTim.create');
        Route::get('/callsignTimStore',[CallsignTimController::class,'store'])->name('callsignTim.store');

        // Route::resource('callsignTim', CallsignTimController::class);

        Route::get('/fatData', [FatController::class, 'fatdata'])->name('fat.data');
        // Route::get('/fatEdit/{id}', [FatController::class, 'edit'])->name('fat.edit');
        Route::resource('fat', FatController::class);

        Route::get('/import', [ImportexcelController::class, 'index'])->name('import.index');
        Route::post('/import-excel', [ImportexcelController::class, 'import'])->name('import.excel');
        Route::resource('import', ImportexcelController::class);

        Route::resource('batchWO', BatchwoController::class);

        Route::get('/batchwodata', [BatchwoController::class, 'batchwodata'])->name('batchwodata.data');
        // Route::resource('batchWOIdx',BatchwoIdxController::class);


        Route::get('/batchwodataMT', [MonitMtFtthController::class, 'batchwodataMT'])->name('batchwodataMT.data');
        Route::get('getCouseCode', [MonitMtFtthController::class, 'getCouseCode'])->name('getCouseCode.data');
        Route::get('getRootCouseCode', [MonitMtFtthController::class, 'getRootCouse'])->name('getRootCouse.data');
        Route::get('getActionTaken', [MonitMtFtthController::class, 'getActionTaken'])->name('getActionTaken.data');
        Route::resource('monitMTFtth', MonitMtFtthController::class);

        Route::get('getWhData', [WarehouseController::class, 'getWhIndex'])->name('getWhdata.data');
        Route::resource('warehouse', WarehouseController::class);

        Route::get('dashWo', [DashWoController::class, 'index'])->name('dashWo');
        Route::get('dashEmployee', [EmployeeDashController::class, 'index'])->name('dashEmployee');

        // Route::get('asetIndex', [AsetIkrController::class, 'index'])->name('aset.index');
        Route::get('/asetData', [AsetIkrController::class, 'datamasterAset'])->name('aset.data');
        Route::resource('aset', AsetIkrController::class);

        Route::resource('peminjaman', PeminjamanAsetController::class);
        Route::post('pinjam',[PeminjamanAsetController::class, 'simpanPinjam'])->name('simpan.pinjam');
        Route::get('getKodeAset', [PeminjamanAsetController::class,'getKodeAset'])->name('getKodeAset');
        Route::get('getKodeGa', [PeminjamanAsetController::class,'getKodeGa'])->name('getKodeGa');
        Route::get('getKodeList', [PeminjamanAsetController::class,'getKodeList'])->name('getKodeList');

        Route::resource('pengembalian', PengembalianAsetController::class);
        Route::resource('disposal', AsetDisposalController::class);

        Route::resource('dashAset', AsetDashController::class);
        Route::get('/DataTotAsetDt', [AsetDashController::class, 'dataTotAsetDt'])->name('dataTotAsetDt');
        Route::get('/DataTersediaAsetDt', [AsetDashController::class, 'dataTersediaAsetDt'])->name('dataTersediaAsetDt');
        Route::get('/DataDistribusiAsetDt', [AsetDashController::class, 'dataDistribusiAsetDt'])->name('dataDistribusiAsetDt');
        Route::get('/DataRusakAsetDt', [AsetDashController::class, 'dataRusakAsetDt'])->name('dataRusakAsetDt');
        Route::get('/DataHilangAsetDt', [AsetDashController::class, 'dataHilangAsetDt'])->name('dataHilangAsetDt');
        Route::get('/DataDisposalAsetDt', [AsetDashController::class, 'dataDisposalAsetDt'])->name('dataDisposalAsetDt');

        Route::resource('dashTim', TimDashController::class);

        Route::get('dashTim2', [TimDashController::class,'dashTim2']);

        Route::get('/asetImport', [AsetImportTempController::class, 'index'])->name('aset.Importindex');
        Route::get('/asetImportData', [AsetImportTempController::class, 'dataTempAset'])->name('aset.Tempdata');
        Route::post('/import-aset', [AsetImportTempController::class, 'importAset'])->name('aset.ImportTempdata');
        Route::post('/save-Import',[AsetImportTempController::class,'saveImport'])->name('aset.ImportSave');
        Route::resource('import',AsetImportTempController::class);

        Route::get('/cek', [LoginController::class,'cek']); 
    }
);
