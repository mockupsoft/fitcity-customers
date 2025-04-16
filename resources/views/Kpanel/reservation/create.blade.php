@extends('Kpanel.layouts.app')

@section('page-title') Rezervasyon Ekle @endsection <!-- Sayfa title'ı ayarlanıyor -->

@section('CssContent')

@endsection

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title">Rezervasyon Ekle</h4>
                    </header>
                    <div class="card-body">
                        @if(!isset($_GET['type']))
                            <p>Ders Türü Seçilmedi!</p>
                        @else
                            @if(!isset($_GET['date']))
                                <form>
                                    <input type="hidden" name="type" value="{{ $_GET['type'] }}">
                                    <div class="form-group col-12 col-md-6 col-lg-6">
                                        <label for="date">Tarih</label>
                                        <input type="date" class="form-control" min="{{ now()->format('Y-m-d') }}" name="date" id="date" placeholder="Tarih" required>
                                    </div>
                                    <div class="form-group col-12 text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Devam Et</button>
                                    </div>
                                </form>
                            @elseif(!isset($_GET['personel_id']))
                                <form>
                                    <input type="hidden" name="type" value="{{ $_GET['type'] }}">
                                    <input type="hidden" name="date" value="{{ $_GET['date'] }}">
                                    <div class="row">
                                        @foreach($personels as $personel)
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <img src="{{ $personel->image }}">
                                                            </div>
                                                            <div class="col-md-8 d-flex justify-content-between align-items-center">
                                                                <div class="d-flex" style="flex-direction: column">
                                                                    {{ $personel->name }}
                                                                    <span>Antrenör</span>
                                                                </div>
                                                                <button name="personel_id" value="{{ $personel->id }}" class="btn btn-sm btn-success">Seç</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </form>
                            @elseif(!isset($_GET['hour']))
                                <form method="post" action="{{ route('reservations.store') }}">@csrf
                                    <input type="hidden" name="type" value="{{ $_GET['type'] }}">
                                    <input type="hidden" name="date" value="{{ $_GET['date'] }}">
                                    <input type="hidden" name="personel_id" value="{{ $_GET['personel_id'] }}">
                                    <div class="row">
                                        @foreach($times as $time)
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 d-flex justify-content-between align-items-center">
                                                                <div class="d-flex" style="flex-direction: column">
                                                                    {{ $time->start_time }} - {{ $time->finish_time }}
                                                                </div>
                                                                <button name="start_finish_time" value="{{ $personel->start_time }}_{{ $time->finish_time }}" class="btn btn-sm btn-success">Seç</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.main-content -->
@endsection

