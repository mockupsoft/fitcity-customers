@extends('Kpanel.layouts.app')

@section('page-title')
    Eğitmenler
@endsection

@section('CssContent')
@endsection

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <header class="card-header">
                        <h4 class="card-title">Eğitmenler</h4>
                    </header>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-vcenter text-nowrap table-hover">
                                                    <thead class="table-success">
                                                    <tr>
                                                        <th class="fw-bold">Ad Soyad</th>
                                                        <th class="fw-bold">Telefon</th>
                                                        <th class="fw-bold">Email</th>
                                                        <th class="fw-bold">işlemler</th>
                                                    </tr>
                                                    </thead>
                                                    @foreach($data as $item)
                                                        <tr>
                                                            <td>
                                                                <a href="{{route('trainers.show', $item->id)}}">
                                                                    {{$item->name}}
                                                                </a>
                                                            </td>
                                                            <td>{{ $item->telefon }}</td>
                                                            <td>{{ $item->email }}</td>
                                                            <td width="10%">
                                                                <a href="{{route('trainers.show', $item->id)}}" class="btn btn-sm btn-primary">
                                                                    <i class="fa fa-eye"></i>
                                                                    Görüntüle
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
