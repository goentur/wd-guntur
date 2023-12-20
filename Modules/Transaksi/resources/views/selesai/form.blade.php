@extends('layouts.app')

@section('content')
<div class="row mb-2 mb-xl-3">
    <div class="col-auto d-none d-sm-block">
        <h3 class="d-inline align-middle">Form {{ $attribute['title'] }}</h3>
    </div>
    <div class="col-auto ms-auto text-end mt-n1">
        <a href="{{ route($attribute['link'].'index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> KEMBALI DATA</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">INFORMASI</h5>
                <h6 class="card-subtitle text-muted">Form yang bertanda (<span class="text-danger">*</span>) <b>wajib</b> diisi.</h6>
            </div>
            <div class="card-body">
                <form action="{{ isset($data)?route($attribute['link'].'update',enkrip($data->id)):route($attribute['link'].'store') }}" method="post">
                    @csrf
                    @isset($data)
                    @method('PUT')
                    @endisset
                    <div class="row mb-3">
                        <div class="col-lg-6 mb-3">
                            <label for="merek" class="form-label">Merek <span class="text-danger">*</span></label>
                            <select required name="merek" id="merek" class="form-control">
                                <option value="">Pilih salah satu</option>
                                @foreach ($mereks as $merek)
                                <option value="{{ $merek->id }}" {{ isset($data)&&$data->merek_id==$merek->id?' selected':''}}{{old('merek')==$merek->id?' selected':'' }}>{{ $merek->nama }}</option>
                                @endforeach
                            </select>
                            @error('merek')
                            <strong class="text-danger text-validation">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="model" class="form-label">Model <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control @error('model')is-invalid @enderror" value="{{ isset($data)?$data->model:old('model') }}" id="model" name="model" placeholder="Masukan model">
                            @error('model')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="plat" class="form-label">Plat Nomor <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control @error('plat')is-invalid @enderror" value="{{ isset($data)?$data->plat:old('plat') }}" id="plat" name="plat" placeholder="Masukan plat nomor">
                            @error('plat')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="tarif" class="form-label">Tarif <span class="text-danger">*</span></label>
                            <input required type="text" class="form-control @error('tarif')is-invalid @enderror" value="{{ isset($data)?$data->tarif:old('tarif') }}" id="tarif" name="tarif" data-inputmask="'alias': 'decimal', 'groupSeparator': ','" placeholder="Masukan tarif">
                            @error('tarif')
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
@push('js')<script>
    $(function() {
        new Choices(document.querySelector("select#merek"))
    });
</script>@endpush