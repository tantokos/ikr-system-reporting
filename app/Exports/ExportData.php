<?php

namespace App\Exports;

use App\Models\DataFtthDismantleOri;
use App\Models\DataFtthDismantleSortir;
use App\Models\DataFtthIbOri;
use App\Models\DataFtthIbSortir;
use App\Models\DataFtthMtOri;
use App\Models\DataFtthMtSortir;
use App\Models\DataFttxIbOri;
use App\Models\DataFttxIbSortir;
use App\Models\DataFttxMtOri;
use App\Models\DataFttxMtSortir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

// class FtthIbSortirExport implements FromQuery
class ExportData implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $data, $type_wo, $bulan, $tahun;

    public function __construct($data, $type_wo, $bulan , $tahun)
    {
        $this->data =$data;
        $this->type_wo = $type_wo;    
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function query()
    {
        switch ($this->data){
            case 'sortir':

                switch ($this->type_wo){
                    case 'FTTH IB':
                        return DataFtthIbSortir::query()
                                                ->whereMonth('tgl_ikr', $this->bulan)
                                                ->whereYear('tgl_ikr', $this->tahun);
                        break;

                    case 'FTTH MT':
                        return DataFtthMtSortir::query()
                                                ->whereMonth('tgl_ikr', $this->bulan)
                                                ->whereYear('tgl_ikr', $this->tahun);
                        break;

                    case 'FTTH Dismantle':
                        return DataFtthDismantleSortir::query()
                                                ->whereMonth('visit_date', $this->bulan)
                                                ->whereYear('visit_date', $this->tahun);
                        break;

                    case 'FTTX IB':
                        return DataFttxIbSortir::query()
                                                ->whereMonth('ib_date', $this->bulan)
                                                ->whereYear('ib_date', $this->tahun);
                        break;

                    case 'FTTX MT':
                        return DataFttxMtSortir::query()
                                                ->whereMonth('mt_date', $this->bulan)
                                                ->whereYear('mt_date', $this->tahun);
                        break;

                }
                break;

            case 'ori':

                switch ($this->type_wo){
                    case 'FTTH IB':
                        return DataFtthIbOri::query()
                                                ->whereMonth('tgl_ikr', $this->bulan)
                                                ->whereYear('tgl_ikr', $this->tahun);
                        break;
    
                    case 'FTTH MT':
                        return DataFtthMtOri::query()
                                                ->whereMonth('tgl_ikr', $this->bulan)
                                                ->whereYear('tgl_ikr', $this->tahun);
                        break;
    
                    case 'FTTH Dismantle':
                        return DataFtthDismantleOri::query()
                                                ->whereMonth('visit_date', $this->bulan)
                                                ->whereYear('visit_date', $this->tahun);
                        break;
    
                    case 'FTTX IB':
                        return DataFttxIbOri::query()
                                                ->whereMonth('ib_date', $this->bulan)
                                                ->whereYear('ib_date', $this->tahun);
                        break;
    
                    case 'FTTX MT':
                        return DataFttxMtOri::query()
                                                ->whereMonth('mt_date', $this->bulan)
                                                ->whereYear('mt_date', $this->tahun);
                        break;
    
                    }
                    break;
        }

    }

    public function headings(): array 
    {
        return array_keys($this->query()->first()->toArray());
    }
}
