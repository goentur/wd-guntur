<?php

namespace Modules\Peminjaman\app\Http\Controllers;

use App\Models\Mobil;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PeminjamanController extends Controller
{
    protected $attribute = [
        'view' => 'peminjaman::',
        'link' => 'peminjaman.',
        'linkSampah' => 'peminjaman.',
        'title' => 'peminjaman',
    ];

    public function index()
    {
        $data = [
            'attribute' => $this->attribute,
        ];
        $user = User::with('userDetail')->find(auth()->user()->id);
        if (!$user->userDetail) {
            return view($this->attribute['view'] . 'profil', $data);
        } else {
            return view($this->attribute['view'] . 'index', $data);
        }
    }
    public function updateProfil(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'telp' => 'required|string',
            'sim' => 'required|numeric',
        ]);
        UserDetail::create([
            'user_id' => auth()->user()->id,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'sim' => $request->sim,
        ]);
        return back()->with('success', 'Pengguna behasil diupdate');
    }
    public function cariData(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'tanggal' => 'required|string',
        ]);
        if ($request->ajax()) {
            $txtTanggalAwal = '~';
            $txtTanggalAkhir = '~';
            if (dekrip($request->type) === 'pertanggal') {
                $tanggal = explode(" to ", $request->tanggal);
                if (!empty($tanggal[0]) && !empty($tanggal[1])) {
                    $txtTanggalAwal = $tanggal[0];
                    $txtTanggalAkhir = $tanggal[1];
                } else {
                    $txtTanggalAwal = $request->tanggal;
                    $txtTanggalAkhir = $request->tanggal;
                }
                $datas = [];
                // cari tanggal awal
                $dataTanggalAwal = Peminjaman::select('mobil_id')->where('status', 'b')->whereBetween('tanggal_awal', [tanggalPembalik($txtTanggalAwal), tanggalPembalik($txtTanggalAkhir)])->get();
                // cari tanggal akhir
                $dataTanggalAkhir = Peminjaman::select('mobil_id')->where('status', 'b')->whereBetween('tanggal_akhir', [tanggalPembalik($txtTanggalAwal), tanggalPembalik($txtTanggalAkhir)])->get();
                $dataTanggalAwalTampungan = [];
                foreach ($dataTanggalAwal as $awal) {
                    $dataTanggalAwalTampungan[] = $awal->mobil_id;
                }
                $dataTanggalAkhirTampungan = [];
                foreach ($dataTanggalAkhir as $akhir) {
                    $dataTanggalAkhirTampungan[] = $akhir->mobil_id;
                }
                $mobilPadaTanggalAwal = array_unique($dataTanggalAwalTampungan);
                $mobilPadaTanggalAkhir = array_unique($dataTanggalAkhirTampungan);
                // data mobil yang di sudah di pesan
                $dataMobil = array_unique(array_merge($mobilPadaTanggalAwal, $mobilPadaTanggalAkhir));
                $mobil = Mobil::with('merek')->select('id', 'merek_id', 'model', 'plat', 'tarif')->whereNotIn('id', $dataMobil)->get();
            } else {
                $mobil = Mobil::with('merek')->select('id', 'merek_id', 'model', 'plat', 'tarif')->get();
            }
            foreach ($mobil as $key => $m) {
                $datas[] = [
                    'no' => ++$key . '.',
                    'merek' => $m->merek ? $m->merek->nama : 'TIDAK DITEMUKAN',
                    'model' => $m->model,
                    'plat' => $m->plat,
                    'tarif' => rupiah($m->tarif) . ' /Hari',
                    'aksi' => enkrip($m->id),
                ];
            }
            return response()->json(['data' => $datas, 'awal' => $txtTanggalAwal, 'akhir' => $txtTanggalAkhir], 200);
        }
    }
    public function data(Request $request)
    {
        $request->validate([
            'id' => 'required|string',
        ]);
        if ($request->ajax()) {
            $data = Mobil::with('merek', 'peminjamanBelum')->select('id', 'merek_id', 'model', 'plat', 'tarif')->find(dekrip($request->id));
            if ($data) {
                $tanggal = [];
                if ($data->peminjamanBelum) {
                    foreach ($data->peminjamanBelum as $p) {
                        $tanggal[] = [
                            'from' => tanggalPembalik($p->tanggal_awal),
                            'to' => tanggalPembalik($p->tanggal_akhir)
                        ];
                    }
                }
                return response()->json([
                    'status' => true,
                    'merek' => $data->merek ? $data->merek->nama : 'TIDAK DITEMUKAN',
                    'model' => $data->model,
                    'plat' => $data->plat,
                    'tarif' => rupiah($data->tarif) . ' /Hari',
                    'tanggal' => $tanggal,
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
            'tanggal' => 'required|string',
        ]);
        if ($request->ajax()) {
            $tanggal = explode(" to ", $request->tanggal);
            if (!empty($tanggal[0]) && !empty($tanggal[1])) {
                $txtTanggalAwal = $tanggal[0];
                $txtTanggalAkhir = $tanggal[1];
            } else {
                $txtTanggalAwal = $request->tanggal;
                $txtTanggalAkhir = $request->tanggal;
            }
            $mobilId = dekrip($request->id);
            $mobil = Mobil::select('id', 'tarif')->find($mobilId);
            Peminjaman::create([
                'user_id' => auth()->user()->id,
                'mobil_id' => $mobilId,
                'tanggal_awal' => tanggalPembalik($txtTanggalAwal),
                'tanggal_akhir' => tanggalPembalik($txtTanggalAkhir),
                'status' => 'b',
                'tarif' => $mobil->tarif,
                'total' => 0,
            ]);
            return response()->json(['status' => true, 'message' => 'Peminjaman berhasil dilakukan'], 200);
        }
    }
}
