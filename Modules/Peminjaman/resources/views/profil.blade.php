@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3 class="d-inline align-middle">Update data diri</h3>
    </div>
    <div class="col-auto ms-auto text-end mt-n1">
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">INFORMASI</h5>
                <h6 class="card-subtitle text-muted">Form yang bertanda (<span class="text-danger">*</span>)
                    <b>wajib</b> diisi.
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route($attribute['link'] . 'update-profil') }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12 mb-3">
                            <label for="alamat" class="form-label">ALAMAT <span class="text-danger">*</span></label>
                            <textarea name="alamat" id="alamat" rows="5" required class="form-control @error('alamat')is-invalid @enderror" placeholder="Masukan alamat">{{ isset($data) ? $data->alamat : old('alamat') }}</textarea>
                            @error('alamat')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="telp" class="form-label">NO TELEPHONE <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control @error('telp')is-invalid @enderror" value="{{ isset($data) ? $data->telp : old('telp') }}" id="telp" name="telp" placeholder="Masukan telp">
                            @error('telp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="sim" class="form-label">NOMOR SIM <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control @error('sim')is-invalid @enderror" value="{{ isset($data) ? $data->sim : old('sim') }}" id="sim" name="sim" data-inputmask="'alias': 'decimal'" placeholder="Masukan sim">
                            @error('sim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(function() {
        new Choices(document.querySelector("select#merek"))
    });
</script>
@endpush