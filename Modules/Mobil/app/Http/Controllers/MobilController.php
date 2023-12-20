<?php

namespace Modules\Mobil\app\Http\Controllers;

use App\Models\Merek;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class MobilController extends Controller
{
    protected $attribute = [
        'view' => 'mobil::',
        'link' => 'mobil.',
        'linkSampah' => 'mobil.',
        'title' => 'mobil',
    ];

    public function index(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
            return DataTables::eloquent(Mobil::with('merek')->select('id', 'merek_id', 'model', 'plat', 'tarif', 'status'))
                ->addIndexColumn()
                ->editColumn('merek.nama', function (Mobil $data) {
                    return $data->merek ? $data->merek->nama : view('errors.master-data');
                })
                ->editColumn('tarif', function (Mobil $data) {
                    return rupiah($data->tarif);
                })
                ->addColumn('aksi', function (Mobil $data) {
                    $kirim = [
                        'data' => $data,
                        'attribute' => $this->attribute,
                    ];
                    return view($this->attribute['view'] . 'aksi', $kirim);
                })->make(true);
        }
        $dataTable = $builder
            ->addIndex(['class' => 'w-1 text-center', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'title' => 'NO'])
            ->addColumn(['class' => 'w-1 top', 'data' => 'merek.nama', 'name' => 'merek.nama', 'title' => 'MEREK'])
            ->addColumn(['data' => 'model', 'name' => 'model', 'title' => 'MODEL'])
            ->addColumn(['data' => 'plat', 'name' => 'plat', 'title' => 'PLAT NOMOR'])
            ->addColumn(['data' => 'tarif', 'name' => 'tarif', 'title' => 'TARIF'])
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

    public function create()
    {
        $data = [
            'attribute' => $this->attribute,
            'mereks' => Merek::select('id', 'nama')->get(),
        ];
        return view($this->attribute['view'] . 'form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'merek' => 'required|numeric',
            'model' => 'required|string',
            'plat' => 'required|string|unique:mobils',
            'tarif' => 'required|string',
        ]);
        Mobil::create([
            'merek_id' => $request->merek,
            'model' => $request->model,
            'plat' => $request->plat,
            'tarif' => str_replace(",", "", $request->tarif)
        ]);
        return redirect()->route($this->attribute['link'] . 'index')->with(['success' => 'Data berhasil disimpan']);
    }

    public function show($id)
    {
        return abort('404');
    }

    public function edit($id)
    {
        $kirim = [
            'attribute' => $this->attribute,
            'data' => Mobil::select('id', 'merek_id', 'model', 'plat', 'tarif')->find(dekrip($id)),
            'mereks' => Merek::select('id', 'nama')->get(),
        ];
        return view($this->attribute['view'] . 'form', $kirim);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'merek' => 'required|numeric',
            'model' => 'required|string',
            'plat' => 'required|string',
            'tarif' => 'required|string',
        ]);
        Mobil::select('id')->find(dekrip($id))->update([
            'merek_id' => $request->merek,
            'model' => $request->model,
            'plat' => $request->plat,
            'tarif' => str_replace(",", "", $request->tarif)
        ]);

        return redirect()->route($this->attribute['link'] . 'index')->with(['success' => 'Data berhasil diubah']);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        if ($request->ajax()) {
            Mobil::select('id')->find(dekrip($request->id))->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus.',
            ]);
        }
    }
}
