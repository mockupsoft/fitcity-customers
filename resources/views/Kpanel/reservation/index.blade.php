@extends('Kpanel.layouts.app')

@section('page-title') Rezevasyonlar @endsection <!-- Sayfa title'ı ayarlanıyor -->

@section('CssContent')
    <!-- Bu sayfaya özel css dosyaları çekilecek -->
@endsection

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title"><strong>Rezevasyonlar</strong></h4>
                        <div class="text-right">
                            <a class="btn btn-success btn-sm mx-1" href="{{route('reservations.create',['type'=>'private_lesson'])}}">Özel Ders Oluştur<i class="fa fa-plus"></i></a>
{{--                            <a class="btn btn-success btn-sm mx-1" href="{{route('reservations.create',['type'=>'group_lesson'])}}">Grup Ders Oluştur<i class="fa fa-plus"></i></a>--}}
                            <a class="btn btn-success btn-sm mx-1" href="{{route('reservations.create',['type'=>'measurement'])}}">Ölçüm Oluştur<i class="fa fa-plus"></i></a>
                        </div>
                    </header>

                    <div class="card-body">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-separated dataTables" id="reservations_table">
                                    <thead>
                                    <tr>
                                        <th class="min-w-100px">Tarih & Saat</th>
                                        <th class="min-w-100px">Eğitmen</th>
                                        <th class="min-w-100px text-right">#</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($reservations as $reservation)
                                        @php
                                            $startTime = \Carbon\Carbon::parse($reservation->lesson_date . ' ' . $reservation->lesson_start_time);
                                            $endTime = \Carbon\Carbon::parse($reservation->lesson_date . ' ' . $reservation->lesson_finish_time);
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $startTime->translatedFormat('d F Y H:i') }} -
                                                {{ $endTime->translatedFormat('d F Y H:i') }}
                                            </td>

                                            <td></td>
                                            <td class="text-right">
{{--                                                <a class="table-action btn btn-success btn-sm" href="{{route('reservations.edit',[$reservation->id])}}"><i class="ti-pencil"></i></a>--}}
                                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="display:inline-block;">
                                                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="table-action btn btn-danger btn-sm"><i class="ti-trash"></i></button>
                                                </form>
                                                @if($endTime->isPast())
                                                    <button type="button" class="table-action btn btn-danger btn-sm" onclick="$('#voteModal{{ $reservation->id }}').modal('show')">Oyla</button>
                                                    <div class="modal fade" id="voteModal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="voteModal{{ $reservation->id }}"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body sanaldmodalbody">
                                                                    <form action="{{ route('reservations.vote') }}" method="POST" style="display:inline-block;">
                                                                        <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                                                        @csrf
                                                                        <div class="form-group col-12 col-md-6 col-lg-6">
                                                                            <label for="vote">Puan</label>
                                                                            <select name="vote" class="form-control" id="vote" required>
                                                                                <option value="">Lütfen Seçim Yapınız</option>
                                                                                <option value="5">Çok İyi</option>
                                                                                <option value="4">İyi</option>
                                                                                <option value="3">Orta</option>
                                                                                <option value="2">Kötü</option>
                                                                                <option value="1">Çok Kötü</option>
                                                                            </select>
                                                                        </div>
                                                                        <button type="button" class="table-action btn btn-danger btn-sm">Oy Ver</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.main-content -->
@endsection

@section('JsContent')
@endsection
