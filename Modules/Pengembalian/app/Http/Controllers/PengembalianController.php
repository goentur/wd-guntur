<?php

namespace Modules\Pengembalian\app\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PengembalianController extends Controller
{
    protected $attribute = [
        'view' => 'pengembalian::',
        'link' => 'pengembalian.',
        'linkSampah' => 'pengembalian.',
        'title' => 'pengembalian',
    ];

    public function index(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
            return DataTables::eloquent(Peminjaman::with('mobil')->select('id', 'mobil_id', 'tanggal_awal', 'tanggal_akhir', 'tarif')->where(['user_id' => auth()->user()->id, 'status' => 'b'])->orderBy('tanggal_akhir', 'ASC'))
                ->addIndexColumn()
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
                })
                ->addColumn('aksi', function (Peminjaman $data) {
                    $kirim = [
                        'data' => $data,
                        'attribute' => $this->attribute,
                    ];
                    return view($this->attribute['view'] . 'aksi', $kirim);
                })->make(true);
        }
        $dataTable = $builder
            ->addIndex(['class' => 'w-1 text-center', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'NO'])
            ->addColumn(['data' => 'mobil.model', 'name' => 'mobil.model', 'title' => 'MOBIL'])
            ->addColumn(['data' => 'mobil.plat', 'name' => 'mobil.plat', 'title' => 'PLAT'])
            ->addColumn(['data' => 'tanggal_awal', 'name' => 'tanggal_awal', 'title' => 'TANGGAL AWAL'])
            ->addColumn(['data' => 'tanggal_akhir', 'name' => 'tanggal_akhir', 'title' => 'TANGGAL AKHIR'])
            ->addColumn(['class' => 'w-1', 'data' => 'tarif', 'name' => 'tarif', 'title' => 'TARIF'])
            ->addColumn(['data' => 'total', 'name' => 'total', 'title' => 'TOTAL'])
            ->addColumn(['class' => 'w-1', 'data' => 'aksi', 'name' => 'aksi', 'title' => 'AKSI'])
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
    public function data(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
        ]);
        if ($request->ajax()) {
            $data = Peminjaman::with('mobil')->select('id', 'mobil_id', 'tanggal_awal', 'tanggal_akhir', 'tarif')->find(dekrip($request->id));
            if ($data) {
                $selisihHari = (strtotime(date('d-m-Y')) - strtotime($data->tanggal_awal)) / (60 * 60 * 24);
                return response()->json([
                    'status' => true,
                    'merek' => $data->mobil->merek ? $data->mobil->merek->nama : 'TIDAK DITEMUKAN',
                    'model' => $data->mobil->model,
                    'plat' => $data->mobil->plat,
                    'awal' => tanggalPembalik($data->tanggal_awal),
                    'akhir' => tanggalPembalik($data->tanggal_akhir),
                    'ini' => date('d-m-Y'),
                    'tarif' => rupiah($data->tarif * $selisihHari) . ' (' . $selisihHari . ' Hari)',
                ], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Mobil tidak ditemukan'], 200);
            }
        }
    }
    public function selesai(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
        ]);
        if ($request->ajax()) {
            $tanggalSaatini = date('Y-m-d');
            $peminjaman = Peminjaman::find(dekrip($request->id));
            $selisihHari = (strtotime($tanggalSaatini) - strtotime($peminjaman->tanggal_awal)) / (60 * 60 * 24);
            $peminjaman->update([
                'tanggal_pengembalian' => $tanggalSaatini,
                'status' => 's',
                'total' => $peminjaman->tarif * $selisihHari,
            ]);
            return response()->json(['status' => true, 'message' => 'Pengembalian berhasil dilakukan'], 200);
        }
    }
}
