@extends('Kpanel.layouts.app')
@section('page-title') İstek, Öneri, Şikayet @endsection
@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title"> Geri Bildirim Ekle</h4>
                    </header>
                    <div class="card-body">
                        <form method="post" action="{{ route('feedbacks.store') }}">
                            @csrf
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="name">Türk </label>
                                <select class="form-control" name="type" id="type">
                                    <option value="">Tür Seçin</option>
                                    <option value="istek">İstek</option>
                                    <option value="öneri">Öneri</option>
                                    <option value="şikayet">Şikayet</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6 col-lg-6">
                                <label for="name">Mesajınız </label>
                                <textarea class="form-control" name="message" id="message" rows="5"
                                          placeholder="Mesajınızı buraya yazın"></textarea>
                            </div>
                            <div class="form-group col-12 text-center">
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

