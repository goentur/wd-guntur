@if ($data->tanggal_awal <= date('Y-m-d'))
    <button class="btn btn-sm btn-icon waves-effect waves-light btn-primary lihat" data-id="{{ enkrip($data->id) }}"><i class="fas fa-eye"></i></button>
@elseif ($data->tanggal_awal > date('Y-m-d'))
    @if ($data->status !== 'x')
        <button class="btn btn-sm btn-icon waves-effect waves-light btn-danger hapus" data-id="{{ enkrip($data->id) }}"><i class="fas fa-trash"></i></button>
    @else
        <span class="badge bg-danger">DIBATALKAN</span>
    @endif
@endif