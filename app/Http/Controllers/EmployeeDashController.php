<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Batchwo;
use App\Models\Employee;
use App\Models\MonitMtFtth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeDashController extends Controller
{
    public function index() 
    {
        // $totWo = Batchwo::where('tgl_ikr', '=', date(now()->format('Y-m-d')))->count();
        $totKaryawan = Employee::where('status_active','=','aktif')->count();
        $totSpv = Employee::where('status_active','=','aktif')->where('posisi','Like','Supervisor%')->count();
        $totStaff = Employee::where('status_active','=','aktif')->where('posisi','Like','Staff%')->count();
        $totLeader = Employee::where('status_active','=','aktif')->where('posisi','Like','Leader%')->count();
        $totInstaller = Employee::where('status_active','=','aktif')->where('posisi','=','Installer')->count();
        $totMaintenance= Employee::where('status_active','=','aktif')->where('posisi','=','Maintenance')->count();

        $totKarPerBranch = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->whereNotNull('branch_id')->select(DB::raw('count(*) as jumlah, branches.nama_branch'))->groupBy('branch_id')->orderByRaw('CONVERT(branch_id, SIGNED) asc')->get()->toJson();

        $totPerMonth = DB::table('employees')->where('status_active','=','Aktif')->select(DB::raw('count(*) as jumlah, CONCAT(substr(nik_karyawan,1,4),"-",substr(nik_karyawan,5,2)) as tahun'))->groupBy('tahun')->orderBy('tahun')->get()->toJson();

        $totPerPosTimur = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','1')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosSelatan = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','2')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosBekasi = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','3')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosBogor = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','4')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosTangerang = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','5')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosMedan = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','6')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosPangkalPinang = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','7')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosPontianak = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','8')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosJambi = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','9')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        $totPerPosBali = DB::table('employees')->leftJoin('branches','branches.id','=','employees.branch_id')->where('status_active','=','Aktif')->where('employees.branch_id','=','10')->select(DB::raw('posisi, count(*) as jumlah'))->groupBy('posisi')->orderBy('posisi')->get()->toJson();

        // dd($totPerPosTimur);
        return view('dashboard.EmployeeDashView',['totalKaryawan' => $totKaryawan, 'totalSpv' => $totSpv, 'totalStaff' => $totStaff, 'totalLeader' => $totLeader, 'totalInstaller' => $totInstaller, 'totalMaintenance' => $totMaintenance, 'totPerBulan' => $totPerMonth,'totKarPerBranch' => $totKarPerBranch, 'totPerPosTimur' => $totPerPosTimur, 'totPerPosSelatan' => $totPerPosSelatan, 'totPerPosBekasi' => $totPerPosBekasi, 'totPerPosBogor' => $totPerPosBogor, 'totPerPosTangerang' => $totPerPosTangerang, 'totPerPosMedan' => $totPerPosMedan, 'totPerPosPangkalPinang' => $totPerPosPangkalPinang, 'totPerPosPontianak' => $totPerPosPontianak, 'totPerPosJambi' => $totPerPosJambi, 'totPerPosBali' => $totPerPosBali]);
    }
}
