<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportFtthMT;
use App\Imports\ImportFtthMTSortir;
use App\Models\DataFtthMtOri;
use App\Models\DataFtthMtSortir;
use App\Models\ImportFtthMtSortirTemp;
use Yajra\DataTables\DataTables;
use App\Models\ImportFtthMtTemp;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ImportFtthMtTempController extends Controller
{
    public function index()
    {

        $akses = Auth::user()->name;
        $jmlData = ImportFtthMtTemp::where('login', '=', $akses)->count('no_wo');

        $sitePenagihan = ImportFtthMtTemp::where('login', '=', $akses)->select('site_penagihan')->distinct()->get();
        $penagihan = ImportFtthMtTemp::where('login', '=', $akses)->select('penagihan')->distinct()->orderBy('penagihan')->get();
        $branch = ImportFtthMtTemp::where('login', '=', $akses)->select('branch')->distinct()->orderBy('branch')->get();
        $kotamadyaPenagihan = ImportFtthMtTemp::where('login', '=', $akses)->select('kotamadya_penagihan')->distinct()->orderBy('kotamadya_penagihan')->get();
        $statWo = ImportFtthMtTemp::where('login', '=', $akses)->select('status_wo')->distinct()->get();

        // query data ORI
        $done = ImportFtthMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done')
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $pending = ImportFtthMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending')
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $cancel = ImportFtthMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel')
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');

        $tglIkr = ImportFtthMtTemp::where('login', '=', $akses)->select(DB::raw('tgl_ikr'))->distinct()->get();

        $detPenagihan = ImportFtthMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('penagihan')->orderBy('penagihan')->get();

        $detCouseCode = ImportFtthMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code, count(*) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->distinct()->groupBy('penagihan', 'couse_code')->orderBy('penagihan')->get();

        $detRootCouse = ImportFtthMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code,root_couse, count(*) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->distinct()->groupBy('penagihan', 'couse_code', 'root_couse')->orderBy('penagihan')->get();
        // end query data ORI

        // query data Sortir

        $doneSortir = DB::table('import_ftth_mt_sortir_temps')->where('status_wo', '=', 'Done')->get();

        $pendingSortir = DB::table('import_ftth_mt_sortir_temps')->where('status_wo', '=', 'Pending')->get();

        $cancelSortir = DB::table('import_ftth_mt_sortir_temps')->where('status_wo', '=', 'Cancel')->get();

        $donePendingSortir = $doneSortir->merge($pendingSortir);
        $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);


        $detPenagihanSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('penagihan')->orderBy('penagihan')->get();

        // // dd($detPenagihanSortir);

        $detCouseCodeSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code, count(*) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            ->groupBy('penagihan', 'couse_code')->orderBy('penagihan')->get();

        $detRootCouseSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code,root_couse, count(*) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            ->groupBy('penagihan', 'couse_code', 'root_couse')->orderBy('penagihan')->get();

        // end query data Sortir

        $TglMin = $tglIkr->min('tgl_ikr');
        $TglMax = $tglIkr->max('tgl_ikr');

        $CekBulanThnImport = DataFtthMtOri::whereBetween('tgl_ikr',[$TglMin, $TglMax])->get();
        // dump($CekBulanThnImport->count());

        if($CekBulanThnImport->count() > 0) {
            $croscekData = "Data Tanggal $TglMin - $TglMax Sudah Pernah di Import";
        }
        else
        {
            $croscekData = "-";
        }


        return view('importWo.FtthMtTempIndex', [
            'title' => 'Import Data FTTH MT', 'akses' => $akses, 'jmlImport' => $jmlData,
            'done' => $done, 'pending' => $pending, 'cancel' => $cancel, 'sitePenagihan' => $sitePenagihan,
            'branch' => $branch, 'kotamadyaPenagihan' => $kotamadyaPenagihan, 'tglIkr' => $tglIkr, 'croscekData' => $croscekData,
            'statusWo' => $statWo, 'penagihan' => $penagihan,
            'detPenagihan' => $detPenagihan, 'detCouseCode' => $detCouseCode, 'detRootCouse' => $detRootCouse,
            'doneSortir' => $doneSortir->count(), 'pendingSortir' => $pendingSortir->count(), 'cancelSortir' => $cancelSortir->count(),
            'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function showSummary()
    {
        $akses = Auth::user()->name;
        $done = ImportFtthMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done')->count('status_wo');
        $pending = ImportFtthMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending')->count('status_wo');
        $cancel = ImportFtthMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel')->count('status_wo');

        $detPenagihan = ImportFtthMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            ->groupBy('penagihan')->orderBy('penagihan')->get();

        $detCouseCode = ImportFtthMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code, count(*) as jml'))
            ->distinct()->groupBy('penagihan', 'couse_code')->orderBy('penagihan')->get();

        $detRootCouse = ImportFtthMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code,root_couse, count(*) as jml'))
            ->distinct()->groupBy('penagihan', 'couse_code', 'root_couse')->orderBy('penagihan')->get();
    }


    public function importFtthMtTemp(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('fileFtthMT')) {

            $request->validate([
                'fileFtthMT' => ['required', 'mimes:xlsx,xls,csv']
            ]);

            $akses = Auth::user()->name;

            Excel::import(new ImportFtthMT($akses), request()->file('fileFtthMT'));

            $doneSortir = DB::table('import_ftth_mt_temps')->where('status_wo', '=', 'Done')->select(DB::raw('no_wo,max(tgl_ikr) as tgl_ikr'))
                ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
                ->orderBy('no_wo')
                ->groupBy('no_wo')->get();

            $pendingSortir = DB::table('import_ftth_mt_temps')->where('status_wo', '=', 'Pending')->select(DB::raw('no_wo,max(tgl_ikr) as tgl_ikr'))
                ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
                ->whereNotIn('no_wo', function ($p) {
                    $p->select('no_wo')->from('import_ftth_mt_temps as import1')->where('status_wo', '=', 'Done');
                })
                ->whereNotIn('no_wo', function ($c) {
                    $c->select('no_wo')->from('import_ftth_mt_temps as import2')->where('status_wo', '=', 'Cancel');
                })
                ->orderBy('no_wo')
                ->groupBy('no_wo')->get();

            $cancelSortir = DB::table('import_ftth_mt_temps')->where('status_wo', '=', 'Cancel')->select(DB::raw('no_wo,max(tgl_ikr) as tgl_ikr'))
                ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
                ->whereNotIn('no_wo', function ($p) {
                    $p->select('no_wo')->from('import_ftth_mt_temps as import1')->where('status_wo', '=', 'Done');
                })
                ->orderBy('no_wo')
                ->groupBy('no_wo')->get();

            $donePendingSortir = $doneSortir->merge($pendingSortir);
            $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);

            for ($x = 0; $x < $donePendingCancelSortir->count(); $x++) {

                $importFtthMtOri = ImportFtthMtTemp::where('no_wo', '=', $donePendingCancelSortir[$x]->no_wo)
                    ->where('tgl_ikr', '=', $donePendingCancelSortir[$x]->tgl_ikr)->first();

                // dd($importFtthMtOri->no_wo);

                ImportFtthMtSortirTemp::create([

                    'pic_monitoring' => $importFtthMtOri->pic_monitoring,
                    'type_wo' => $importFtthMtOri->type_wo,
                    'no_wo' => $importFtthMtOri->no_wo,
                    'no_ticket' => $importFtthMtOri->no_ticket,
                    'cust_id' => $importFtthMtOri->cust_id,
                    'nama_cust' => $importFtthMtOri->nama_cust,
                    'cust_address1' => $importFtthMtOri->cust_address1,
                    'cust_address2' => $importFtthMtOri->cust_address2,
                    'type_maintenance' => $importFtthMtOri->type_maintenance,
                    'kode_fat' => $importFtthMtOri->kode_fat,
                    'kode_wilayah' => $importFtthMtOri->kode_wilayah,
                    'cluster' => $importFtthMtOri->cluster,
                    'kotamadya' => $importFtthMtOri->kotamadya,
                    'kotamadya_penagihan' => $importFtthMtOri->kotamadya_penagihan,
                    'branch' => $importFtthMtOri->branch,
                    'tgl_ikr' => $importFtthMtOri->tgl_ikr,
                    'slot_time_leader' => $importFtthMtOri->slot_time_leader,
                    'slot_time_apk' => $importFtthMtOri->slot_time_apk,
                    'sesi' => $importFtthMtOri->sesi,
                    'remark_traffic' => $importFtthMtOri->remark_traffic,
                    'callsign' => $importFtthMtOri->callsign,
                    'leader' => $importFtthMtOri->leader,
                    'teknisi1' => $importFtthMtOri->teknisi1,
                    'teknisi2' => $importFtthMtOri->teknisi2,
                    'teknisi3' => $importFtthMtOri->teknisi3,
                    'status_wo' => $importFtthMtOri->status_wo,
                    'couse_code' => $importFtthMtOri->couse_code,
                    'root_couse' => $importFtthMtOri->root_couse,
                    'penagihan' => $importFtthMtOri->penagihan,
                    'alasan_tag_alarm' => $importFtthMtOri->alasan_tag_alarm,
                    'tgl_jam_reschedule' => $importFtthMtOri->tgl_jam_reschedule,
                    'tgl_jam_fat_on' => $importFtthMtOri->tgl_jam_fat_on,
                    'action_taken' => $importFtthMtOri->action_taken,
                    'panjang_kabel' => $importFtthMtOri->panjang_kabel,
                    'weather' => $importFtthMtOri->weather,
                    'remark_status' => $importFtthMtOri->remark_status,
                    'action_status' => $importFtthMtOri->action_status,
                    'visit_novisit' => $importFtthMtOri->visit_novisit,
                    'start_ikr_wa' => $importFtthMtOri->start_ikr_wa,
                    'end_ikr_wa' => $importFtthMtOri->end_ikr_wa,
                    'validasi_start' => $importFtthMtOri->validasi_start,
                    'validasi_end' => $importFtthMtOri->validasi_end,
                    'checkin_apk' => $importFtthMtOri->checkin_apk,
                    'checkout_apk' => $importFtthMtOri->checkout_apk,
                    'status_apk' => $importFtthMtOri->status_apk,
                    'keterangan' => $importFtthMtOri->keterangan,
                    'ms_regular' => $importFtthMtOri->ms_regular,
                    'wo_date_apk' => $importFtthMtOri->wo_date_apk,
                    'wo_date_mail_reschedule' => $importFtthMtOri->wo_date_mail_reschedule,
                    'wo_date_slot_time_apk' => $importFtthMtOri->wo_date_slot_time_apk,
                    'actual_sla_wo_minute_apk' => $importFtthMtOri->actual_sla_wo_minute_apk,
                    'actual_sla_wo_jam_apk' => $importFtthMtOri->actual_sla_wo_jam_apk,
                    'mttr_over_apk_minute' => $importFtthMtOri->mttr_over_apk_minute,
                    'mttr_over_apk_jam' => $importFtthMtOri->mttr_over_apk_jam,
                    'mttr_over_apk_persen' => $importFtthMtOri->mttr_over_apk_persen,
                    'status_sla' => $importFtthMtOri->status_sla,
                    'root_couse_before' => $importFtthMtOri->root_couse_before,
                    'slot_time_assign_apk' => $importFtthMtOri->slot_time_assign_apk,
                    'slot_time_apk_delay' => $importFtthMtOri->slot_time_apk_delay,
                    'status_slot_time_apk_delay' => $importFtthMtOri->status_slot_time_apk_delay,
                    'ket_delay_slot_time' => $importFtthMtOri->ket_delay_slot_time,
                    'konfirmasi_customer' => $importFtthMtOri->konfirmasi_customer,
                    'ont_merk_out' => $importFtthMtOri->ont_merk_out,
                    'ont_sn_out' => $importFtthMtOri->ont_sn_out,
                    'ont_mac_out' => $importFtthMtOri->ont_mac_out,
                    'ont_merk_in' => $importFtthMtOri->ont_merk_in,
                    'ont_sn_in' => $importFtthMtOri->ont_sn_in,
                    'ont_mac_in' => $importFtthMtOri->ont_mac_in,
                    'router_merk_out' => $importFtthMtOri->router_merk_out,
                    'router_sn_out' => $importFtthMtOri->router_sn_out,
                    'router_mac_out' => $importFtthMtOri->router_mac_out,
                    'router_merk_in' => $importFtthMtOri->router_merk_in,
                    'router_sn_in' => $importFtthMtOri->router_sn_in,
                    'router_mac_in' => $importFtthMtOri->router_mac_in,
                    'stb_merk_out' => $importFtthMtOri->stb_merk_out,
                    'stb_sn_out' => $importFtthMtOri->stb_sn_out,
                    'stb_mac_out' => $importFtthMtOri->stb_mac_out,
                    'stb_merk_in' => $importFtthMtOri->stb_merk_in,
                    'stb_sn_in' => $importFtthMtOri->stb_sn_in,
                    'stb_mac_in' => $importFtthMtOri->stb_mac_in,
                    'dw_out' => $importFtthMtOri->dw_out,
                    'precon_out' => $importFtthMtOri->precon_out,
                    'bad_precon' => $importFtthMtOri->bad_precon,
                    'fast_connector' => $importFtthMtOri->fast_connector,
                    'patchcord' => $importFtthMtOri->patchcord,
                    'terminal_box' => $importFtthMtOri->terminal_box,
                    'remote_fiberhome' => $importFtthMtOri->remote_fiberhome,
                    'remote_extrem' => $importFtthMtOri->remote_extrem,
                    'port_fat' => $importFtthMtOri->port_fat,
                    'site_penagihan' => $importFtthMtOri->site_penagihan,
                    'konfirmasi_penjadwalan' => $importFtthMtOri->konfirmasi_penjadwalan,
                    'konfirmasi_cst' => $importFtthMtOri->konfirmasi_cst,
                    'konfirmasi_dispatch' => $importFtthMtOri->konfirmasi_dispatch,
                    'remark_status2' => $importFtthMtOri->remark_status2,
                    'login' => $akses
                ]);
            }

            return back();
        }
    }

    public function dataImportFtthTemp(Request $request)
    {
        $akses = Auth::user()->name;
        if ($request->ajax()) {
            $datas = ImportFtthMtTemp::where('login', '=', $akses)->get();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function saveImportFtthMt(Request $request)
    {
        $akses = Auth::user()->name;

        switch ($request->input('action')) {

            case 'simpan':

                // ===== copy data Ftth MT Ori Temporary ke table Data Ftth MT Ori ======//
                $dataimportFtthMtOri = ImportFtthMtTemp::where('login', '=', $akses)->get()
                    ->each(function ($item) {
                        $dataFtthMtOri = $item->replicate();
                        $dataFtthMtOri->setTable('data_ftth_mt_oris');
                        $dataFtthMtOri->save();
                    });

                if ($dataimportFtthMtOri) {

                    // ==== copy data Ftth Mt Sortir Temporary ke table Data Ftth Mt Sortir =======//
                    $dataimportFtthMtSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->get()
                        ->each(function ($item) {
                            $dataFtthMtSortir = $item->replicate();
                            $dataFtthMtSortir->setTable('data_ftth_mt_sortirs');
                            $dataFtthMtSortir->save();
                        });

                    ImportFtthMtTemp::where('login', '=', $akses)->delete();
                    ImportFtthMtSortirTemp::where('login', '=', $akses)->delete();
                }

                break;

            case 'batal':
                ImportFtthMtTemp::where('login', '=', $akses)->delete();
                ImportFtthMtSortirTemp::where('login', '=', $akses)->delete();

                break;
        }

        return back();
    }
}
