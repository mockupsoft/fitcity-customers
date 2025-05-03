<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Customer;
use App\Models\PotentialCustomer;
use App\Models\PotentialCustomerInfo;
use App\Models\User;
use Illuminate\Http\Request;

class PotentialCustomerController extends Controller
{
    public function index()
    {
        $cities = Cities::where('status',1)->get();
        $customers = Customer::where('durum',1)->get();
        $users = User::all();
        $potentialCustomers = PotentialCustomer::where('referans_uye', auth()->user()->id)
            ->orWhere('ilgilenen_kisi', auth()->user()->id)
            ->orWhere('uye_danismani', auth()->user()->id)
            ->orWhere('uye_danismani2', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('Kpanel.potential_customer.create', compact(['potentialCustomers', 'cities', 'customers', 'users']));
    }

    public function store(Request $request)
    {
        $cleanedTelefon = str_replace(['(', ')', ' ', '-'], '', $request->telefon);
        $cleanedEvTelefonu = str_replace(['(', ')', ' ', '-'], '', $request->ev_telefonu);

        $existingCustomer = Customer::where(function ($query) use ($cleanedTelefon) {
            $query->where('telefon', '0'.$cleanedTelefon);
        })->first();

        if ($existingCustomer) {
            return  redirect()->route('potential-customers.index')->with('info','Bu telefon numarasıyla bir müşteri zaten kayıtlı');
        }

        $potentialCustomer = new PotentialCustomer();
        $potentialCustomer->ad = $request->ad;
        $potentialCustomer->soyad = $request->soyad;
        $potentialCustomer->telefon = $cleanedTelefon;
        $potentialCustomer->ev_telefonu = $cleanedEvTelefonu;
        $potentialCustomer->email = $request->email;
        $potentialCustomer->adres = $request->adres;
        $potentialCustomer->sehir_id = $request->sehir_id;
        $potentialCustomer->ilce_id = $request->ilce_id;
        $potentialCustomer->kaynak1 = $request->kaynak1;
        $potentialCustomer->kaynak2 = $request->kaynak2;
        $potentialCustomer->referans_uye = $request->referans_uye;
        $potentialCustomer->ilgilenen_kisi = $request->ilgilenen_kisi;
        $potentialCustomer->uye_danismani = $request->uye_danismani;
        $potentialCustomer->uye_danismani2 = $request->uye_danismani2;
        $potentialCustomer->note = $request->note;
        $potentialCustomer->email_gonder = $request->email_gonder ?? 0;
        $potentialCustomer->sms_gonder = $request->sms_gonder ?? 0;
        $potentialCustomer->save();

        $potentialCustomerCorporate = new PotentialCustomerInfo();
        $potentialCustomerCorporate->potential_customer_id = $potentialCustomer->id;
        $potentialCustomerCorporate->meslek = $request->meslek;
        $potentialCustomerCorporate->firma_adi = $request->firma_adi;
        $potentialCustomerCorporate->firma_adres = $request->firma_adres;
        $potentialCustomerCorporate->firma_sehir_id = $request->firma_sehir_id;
        $potentialCustomerCorporate->firma_ilce_id = $request->firma_ilce_id;
        $potentialCustomerCorporate->cinsiyet = $request->cinsiyet;
        $potentialCustomerCorporate->dogum_tarihi = $request->dogum_tarihi;
        $potentialCustomerCorporate->medeni_hali = $request->medeni_hali;
        $potentialCustomerCorporate->save();

        return  redirect()->route('potential-customers.index')->with('success', 'Kayıt Başarılı');
    }
}
