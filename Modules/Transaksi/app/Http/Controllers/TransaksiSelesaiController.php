<?php

namespace Modules\Transaksi\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class TransaksiSelesaiController extends Controller
{
    protected $attribute = [
        'view' => 'transaksi::selesai.',
        'link' => 'transaksi.selesai.',
        'linkSampah' => 'transaksi.selesai.',
        'title' => 'transaksi selesai',
    ];

    public function index(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
            return DataTables::eloquent(Peminjaman::with('mobil', 'user')->select('id', 'user_id', 'mobil_id', 'tanggal_awal', 'tanggal_akhir', 'tarif', 'status')->where('status', 's')->orderBy('tanggal_akhir', 'ASC')->orderBy('status', 'ASC'))
                ->addIndexColumn()
                ->editColumn('user.nama', function (Peminjaman $data) {
                    return $data->user && $data->user->userDetail ? $data->user->name . ' - ' . $data->user->userDetail->telp : view('errors.master-data');
                })
                ->editColumn('mobil.model', function (Peminjaman $data) {
                    return $data->mobil && $data->mobil->merek ? $data->mobil->merek->nama . ' - ' . $data->mobil->model : view('errors.master-data');
                })
                ->editColumn('mobil.plat', function (Peminjaman $data) {
                    return $data->mobil ? $data->mobil->plat : view('errors.master-data');
                })
                ->editColumn('tanggal_awal', function (Peminjaman $data) {
                    return tanggalPembalik($data->tanggal_awal);
                })
                ->editColumn('tanggal_akhir', function (Peminjaman $data) {
                    return tanggalPembalik($data->tanggal_akhir);
                })
                ->editColumn('tarif', function (Peminjaman $data) {
                    return rupiah($data->tarif);
                })
                ->editColumn('total', function (Peminjaman $data) {
                    $selisihHari = (strtotime($data->tanggal_akhir) - strtotime($data->tanggal_awal)) / (60 * 60 * 24);
                    return rupiah($data->tarif * $selisihHari) . ' (' . $selisihHari . ' Hari)';
                })->make(true);
        }
        $dataTable = $builder
            ->addIndex(['class' => 'w-1 text-center', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'NO'])
            ->addColumn(['data' => 'user.nama', 'name' => 'user.nama', 'title' => 'PEMESAN'])
            ->addColumn(['data' => 'mobil.model', 'name' => 'mobil.model', 'title' => 'MOBIL'])
            ->addColumn(['data' => 'mobil.plat', 'name' => 'mobil.plat', 'title' => 'PLAT'])
            ->addColumn(['data' => 'tanggal_awal', 'name' => 'tanggal_awal', 'title' => 'AWAL'])
            ->addColumn(['data' => 'tanggal_akhir', 'name' => 'tanggal_akhir', 'title' => 'AKHIR'])
            ->addColumn(['class' => 'w-1', 'data' => 'tarif', 'name' => 'tarif', 'title' => 'TARIF'])
            ->addColumn(['data' => 'total', 'name' => 'total', 'title' => 'TOTAL'])
            ->parameters([
                'ordering' => false,
                'responsive' => true,
                'bAutoWidth' => false,
                'lengthMenu' => [25, 50, 75, 100],
                'language' => [
                    'url' => asset('js/id.json'),
                ],
            ]);
        $data = [
            'attribute' => $this->attribute,
            'dataTable' => $dataTable,
        ];
        return view($this->attribute['view'] . 'index', $data);
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        if ($request->ajax()) {
            Peminjaman::select('id')->find(dekrip($request->id))->update(['status' => 'x']);
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dibatalkan.',
            ]);
        }
    }
}
