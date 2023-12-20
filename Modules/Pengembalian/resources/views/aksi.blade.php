@if ($data->tanggal_awal <= date('Y-m-d'))
    <button class="btn btn-sm btn-icon waves-effect waves-light btn-primary lihat" data-id="{{ enkrip($data->id) }}"><i
            class="fas fa-eye"></i></button>
@else
    <button class="btn btn-sm btn-icon waves-effect waves-light btn-danger hapus" data-id="{{ enkrip($data->id) }}"><i
            class="fas fa-trash"></i></button>
@endif
