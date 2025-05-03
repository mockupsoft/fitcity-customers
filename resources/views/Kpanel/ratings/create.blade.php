@extends('Kpanel.layouts.app')
@section('page-title') Değerlendir @endsection

@section('CssContent')
    <style>
        .options_table img {
            max-width: 32px;
            max-height: 32px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <form id="mainForm" action="{{ route('ratings.store') }}" method="post">
        @csrf
        <input type="hidden" name="club_id" value="1">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h4 class="card-title mb-0">Değerlendir</h4>
            </div>
            <div class="card-body">
                @php
                    $criteria = [
                        'cleanliness' => 'Temizlik',
                        'maintenance' => 'Arıza',
                        'trainers' => 'Eğitmenler',
                        'friendliness' => 'Güler Yüzlülük',
                        'service' => 'Hizmet',
                        'general' => 'Genel Puan'
                    ];
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                        <tr>
                            <th>Kriter</th>
                            <th colspan="5">Puan (1 - 5)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($criteria as $name => $label)
                            <tr>
                                <td class="text-start fw-semibold">{{ $label }}</td>
                                @for ($i = 1; $i <= 5; $i++)
                                    <td>
                                        <input type="radio" name="{{ $name }}" value="{{ $i }}" required>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fa fa-save me-1"></i> Kaydet
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('JsContent')
@endsection