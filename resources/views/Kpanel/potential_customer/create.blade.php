@extends('Kpanel.layouts.app')
@section('page-title') Potansiyel Üye Ekle @endsection

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
    <form id="mainForm" action="{{route('potential-customers.store')}}" method="post" enctype="multipart/form-data">@csrf
        <div class="main-content">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <header class="card-header">
                            <h4 class="card-title">Potansiyel Üye Ekle</h4>
                        </header>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-9">
                                    <div class="row">
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            @include('utilities.select', ['title' => 'Kaynak', 'required' => 'true', 'id' => 'kaynak1', 'name' => 'kaynak1', 'options' => array_merge(['' => 'Lütfen Seçim Yapınız'], __('arrays.potential-customers.sources'))])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            @include('utilities.select', ['title' => 'Kaynak 2', 'id' => 'kaynak2', 'name' => 'kaynak2', 'options' => ['' => 'Lütfen Seçim Yapınız']])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            @include('utilities.input', ['title' => 'Ad', 'id' => 'ad', 'name' => 'ad', 'required' => 'true'])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            @include('utilities.input', ['title' => 'Soyad', 'id' => 'soyad', 'name' => 'soyad', 'required' => 'true'])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            @include('utilities.input', ['title' => 'Ev Telefonu', 'id' => 'ev_telefonu', 'name' => 'ev_telefonu', 'class' => 'telephone'])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            @include('utilities.input', ['title' => 'Cep Telefonu', 'id' => 'telefonu', 'name' => 'telefon', 'placeholder' => '(000) 000 0000', 'class' => 'telephone', 'required' => 'true'])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            @include('utilities.input', ['title' => 'Adres', 'id' => 'adres', 'name' => 'adres'])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            <label class="form-label" for="il">İl</label>
                                            <select name="il" id="il" class="form-control select2">
                                                <option value="">Lütfen Seçim Yapınız</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-12 col-md-6 col-lg-4">
                                            <label class="form-label" for="ilce">İlçe</label>
                                            <select name="ilce" id="ilce" class="form-control select2">
                                                <option value="">Lütfen Seçim Yapınız</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-12 col-md-6 col-lg-8">
                                            @include('utilities.input', ['title' => 'Email', 'id' => 'email', 'name' => 'email', 'placeholder' => '@', 'type' => 'email'])
                                        </div>
                                        <div class="form-group col-12 col-md-6 col-lg-8">
                                            <div>
                                                <input name="email_gonder" value="1" type="checkbox"> E-mail İzni Yok<br>
                                                <input name="sms_gonder" value="1" type="checkbox"> SMS İzni Yok<br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label>Referans Üye</label>
                                        <select class="form-control form-control-sm" name="referans_uye">
                                            <option value="">Seçim Yapınız</option>
                                            @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{ $customer->fullName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>İlgilenen Kişi</label>
                                        <select class="form-control form-control-sm" required name="ilgilenen_kisi">
                                            <option value="">Seçim Yapınız</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Üye Danışmanı</label>
                                        <select class="form-control form-control-sm" required name="uye_danismani">
                                            <option value="">Seçim Yapınız</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Üye Danışmanı 2</label>
                                        <select class="form-control form-control-sm" name="uye_danismani2">
                                            <option value="">Seçim Yapınız</option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
                                        <th class="fw-bold">Adres</th>
                                        <th class="fw-bold">Referans Üye</th>
                                    </tr>
                                    </thead>
                                    @foreach($potentialCustomers as $potentialCustomer)
                                        <tr>
                                            <td>{{ $potentialCustomer->fullName() }}</td>
                                            <td>{{ $potentialCustomer->telefon }}</td>
                                            <td>{{ $potentialCustomer->email }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($potentialCustomer->adres, 30) }}</td>
                                            <td>{{ $potentialCustomer->getReferansUye->ad }} {{ $potentialCustomer->getReferansUye->soyad }}</td>
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

@endsection

@section('JsContent')
    <script>
        $(document).ready(function() {
            $('#il').change(function() {
                var cityId = $(this).val();
                if (cityId) {
                    $.ajax({
                        url: "{{ route('getCounties') }}",
                        type: "POST",
                        data: {
                            city_id: cityId,
                            _token: "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.type) {
                                $('#ilce').html(response.return_text);
                            } else {
                                alert(response.message);
                                $('#ilce').html('<option value="">Lütfen Seçim Yapınız</option>');
                            }
                        },
                        error: function() {
                            alert("Bir hata oluştu. Lütfen tekrar deneyin.");
                        }
                    });
                } else {
                    $('#ilce').html('<option value="">Lütfen Seçim Yapınız</option>');
                }
            });
        });
    </script>
@endsection