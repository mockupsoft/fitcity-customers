@extends('Kpanel.layouts.app')

@section('page-title')
    Eğitmen
@endsection

@section('CssContent')
@endsection
@section('content')
    <div class="main-content">
        <nav aria-label="breadcrumb" class="mt-3 ms-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Anasayfa</a></li>
                <li class="breadcrumb-item"><a href="{{ route('trainers.index') }}">Eğitmenler</a></li>
                <li class="breadcrumb-item active" aria-current="page">Eğitmen Detay</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Eğitmen Bilgileri</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Ad Soyad:</strong> {{ ucfirst($data->name) }}</p>
                        <p><strong>Ad Soyad:</strong> {{ $data->telefon }}</p>
                        <p><strong>Biografi:</strong></p>
                        <p>{{ $data->informations->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('JsContent')
@endsection
