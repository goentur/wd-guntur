@extends('layouts.app')
<!-- pertama looping data tanggal awal cek dulu apakah ada. kalau ada taruh diarray
tanggal akhir looping lagi cek kalau ada tarih aarray -->
@section('content')
    <div class="row mb-2 mb-xl-3">
        <div class="col-auto d-none d-sm-block">
            <h3 class="d-inline align-middle">Daftar mobil yang tersedia</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-6 mb-5">
                        <div class="form-group">
                            <form action="javascript:void(0)" id="formCariMobil" method="post">
                                <label class="form-label h4"><i class="fa fa-calendar-alt"></i> CARI MOBIL BERDASARKAN
                                    TANGGAL PEMINJAMAN :</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" required id="tanggal"
                                        name="tanggal" placeholder="Pilih tanggal peminjaman" />
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> CARI
                                        MOBIL</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h4 class="text-center">PERIODE PENCARIAN DATA</h4>
                    <h3 class="text-center">
                        <span id="textTanggalAwal">~</span> <b>S.D.</b> <span id="textTanggalAkhir">~</span>
                    </h3>
                    <table id="data" class="table table-sm table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>MEREK</th>
                                <th>MODEL</th>
                                <th>PLAT NOMOR</th>
                                <th>TARIF</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- BEGIN primary modal -->
    <div class="modal fade" id="modalPeminjaman" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" id="formPeminjaman" method="post">
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
                            <tr>
                                <td class="fw-bold">TARIF</td>
                                <td class="w-1">:</td>
                                <td id="textTarif"></td>
                            </tr>
                        </table>
                        <hr>
                        <div class="form-group">
                            <label class="form-label h4"><i class="fa fa-calendar-alt"></i> TANGGAL PEMINJAMAN :</label>
                            <input type="text" class="form-control form-control-lg" required id="tanggalPeminjaman"
                                placeholder="Pilih tanggal peminjaman" />
                        </div>
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
@endpush
@push('js')
    <script>
        var id = null;

        function setTanggal(a) {
            flatpickr("#tanggalPeminjaman", {
                mode: "range",
                dateFormat: "d-m-Y",
                minDate: "{{ date('d-m-Y') }}",
                disable: a
            })
        }

        function data(type, a) {
            $("table#data").DataTable({
                ordering: !1,
                responsive: !0,
                bAutoWidth: !1,
                lengthMenu: [25, 50, 75, 100],
                language: {
                    url: "{{ asset('js/id.json') }}"
                },
                bDestroy: !0,
                processing: !0,
                ajax: {
                    url: "{{ route($attribute['link'] . 'cari-data') }}",
                    type: "POST",
                    data: {
                        type: type,
                        tanggal: a
                    },
                    error: function(a, t, e) {
                        alertApp("error", "Data tidak bisa ditampilkan.")
                    }
                },
                columns: [{
                    className: "w-1 text-center",
                    data: "no"
                }, {
                    data: "merek"
                }, {
                    data: "model"
                }, {
                    data: "plat"
                }, {
                    data: "tarif"
                }, {
                    className: "w-1 text-center",
                    data: "aksi",
                    render: function(a, t, e) {
                        return '<button class="btn btn-sm btn-icon waves-effect waves-light btn-primary pinjam" data-id="' +
                            a + '"><i class="fas fa-check"></i></button>'
                    }
                }, ],
                initComplete: function(a, t) {
                    $("#textTanggalAwal").html(t.awal), $("#textTanggalAkhir").html(t.akhir)
                }
            })
        }
        $(function() {
            flatpickr("#tanggal", {
                mode: "range",
                dateFormat: "d-m-Y",
                minDate: "{{ date('d-m-Y') }}"
            }), data("{{ enkrip('semua') }}", "{{ date('d-m-Y') }}")
        }), $("#formCariMobil").submit(function() {
            var a = $("#tanggal").val();
            a ? data("{{ enkrip('pertanggal') }}", a) : alertApp("error", "Form tidak memenuhi syarat")
        }), $(document).on("click", ".pinjam", function() {
            id = $(this).data("id"), $.post("{{ route($attribute['link'] . 'data') }}", {
                id: id
            }, function(a) {
                a.status ? ($("#tanggalPeminjaman").val(null), $("#textMerek").html(a.merek), $(
                    "#textModel").html(a.model), $("#textPlat").html(a.plat), $("#textTarif").html(a
                    .tarif), $("#modalPeminjaman").modal("show"), setTanggal(a.tanggal)) : alertApp(
                    "error", "Data tidak ditemukan")
            }).fail(function(a, t, e) {
                alertApp("error", e)
            })
        }), $("#formPeminjaman").submit(function() {
            var a = $("#tanggalPeminjaman").val();
            id && a ? $.post("{{ route($attribute['link'] . 'selesai') }}", {
                id: id,
                tanggal: a
            }, function(a) {
                a.status ? ($("#tanggalPeminjaman").val(null), id = null, alertApp("success", a.message), $(
                    "#modalPeminjaman").modal("hide")) : alertApp("error", a.message)
            }).fail(function(a, t, e) {
                alertApp("error", e)
            }) : alertApp("error", "Form tidak memenuhi syarat")
        });
    </script>
@endpush
