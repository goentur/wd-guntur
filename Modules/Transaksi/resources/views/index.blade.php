@extends('layouts.app')

@push('vendor-css')
    <link rel="stylesheet" href="{{ asset('css/jquery-confirm.min.css') }}">
@endpush
@section('content')
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3 class="d-inline align-middle">Data {{ $attribute['title'] }}</h3>
        </div>
        <div class="col-auto ms-auto text-end mt-n1">
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $dataTable->table(['class' => 'table table-bordered table-hover table-sm']) }}
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN primary modal -->
    <div class="modal fade" id="modalPengembalian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" id="formPengembalian" method="post">
                    <div class="modal-header">
                        <h3>FORM PEMINJAMAN</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body m-3">
                        <h4><i class="fa fa-truck"></i> INFORMASI MOBIL</h4>
                        <table class="table-sm">
                            <tr>
                                <td class="fw-bold w-4">MEREK</td>
                                <td class="w-1">:</td>
                                <td id="textMerek"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">MODAL</td>
                                <td class="w-1">:</td>
                                <td id="textModel"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">PLAT NOMOR</td>
                                <td class="w-1">:</td>
                                <td id="textPlat"></td>
                            </tr>
                        </table>
                        <h4><i class="fa fa-calendar"></i> INFORMASI PEMINJAMAN</h4>
                        <table class="table-sm">
                            <tr>
                                <td class="fw-bold">TANGGAL AWAL</td>
                                <td class="w-1">:</td>
                                <td id="textTanggalAwal"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">TANGGAL AKHIR</td>
                                <td class="w-1">:</td>
                                <td id="textTanggalAkhir"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">TANGGAL SAAT INI</td>
                                <td class="w-1">:</td>
                                <td id="textTanggalSaatIni"></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">TARIF</td>
                                <td class="w-1">:</td>
                                <td id="textTarif"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fa fa-close"></i>
                            TUTUP</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END primary modal -->
@endsection
@push('vendor-js')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/jquery-confirm.min.js') }}"></script>
@endpush
@push('js')
    {{ $dataTable->scripts() }}
    <script>
        var id = null;
        $(document).on("click", ".hapus", function() {
            var t = $(this).data("id");
            $.confirm({
                icon: "fa fa-warning",
                title: "PERINGATAN!",
                content: "Apakah anda yakin ingin membatalkan peminjaman ini?",
                type: "red",
                autoClose: "tutup|5000",
                buttons: {
                    ya: {
                        text: "Ya",
                        btnClass: "btn-red",
                        action: function() {
                            $.ajax({
                                url: "{{ route($attribute['link'] . 'destroy', csrf_token()) }}",
                                type: "POST",
                                data: {
                                    _method: "DELETE",
                                    id: t
                                },
                                dataType: "JSON",
                                success: function(t) {
                                    t.status ? (alertApp("success", t.message), $(
                                            "#dataTableBuilder").DataTable().ajax
                                        .reload()) : alertApp("error", t.message)
                                },
                                error: function(t, a, e) {
                                    alertApp("error", e)
                                }
                            })
                        }
                    },
                    tutup: {
                        text: "Tutup"
                    }
                }
            })
        });
    </script>
@endpush
