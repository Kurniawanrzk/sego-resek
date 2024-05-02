@extends('layouts.master')
@section('content')
<div class="container-hero" id="hero">
    <div class="logo-sego-resek-container">
        <img src="assets/img/logo.png" alt="LOGO SEGO RESEK">
    </div>
</div>
<div class="container mb-4`">
   <div class="menu">
    <div class="title-menu">
        <h3 align="center">--------M E N U--------</h3>
    </div>

   <div>
    <div class="">
            <h4 align="center">Makanan</h4>
            <div class="row mt-3 d-flex">
                @foreach ( $with["menu_makanan"] as $makanan)
                <div class="col-lg-4 mb-4">
                    <div class="card p-2" style="width: 18rem;">
                        <img src="{{ $makanan->file_foto }}" style="border:20px solid #f0e8d4ac;border-radius:10px;" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title" style="background:#f0e8d4ac;width:fit-content;padding:10px;border-radius:10px;color:#ac9b6d">{{$makanan->nama_menu}}<br/>Rp.{{$makanan->harga_menu}}</h5>
                            <p style="background:#f0e8d4ac;width:fit-content;padding:10px;border-radius:10px;color:#ac9b6d" class="card-text">{{$makanan->deskripsi}}</p>
                        </div>
                    </div>
                </div>
                @endforeach

        </div>
        <h4 align="center">Minuman</h4>
        <div class="row mt-3 d-flex">
            @foreach ( $with["menu_minuman"] as $makanan)
            <div class="col-lg-4 mb-4">
                <div class="card p-2" style="width: 18rem;">
                    <img src="{{ $makanan->file_foto }}" style="border:20px solid #f0e8d4ac;border-radius:10px;" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title" style="background:#f0e8d4ac;width:fit-content;padding:10px;border-radius:10px;color:#ac9b6d">{{$makanan->nama_menu}}<br/>Rp.{{$makanan->harga_menu}}</h5>
                        <p style="background:#f0e8d4ac;width:fit-content;padding:10px;border-radius:10px;color:#ac9b6d" class="card-text">{{$makanan->deskripsi}}</p>
                    </div>
                </div>
            </div>
            @endforeach

            <center><a href="{{Route("menu")}}"><button class="btn btn-light" style="font-size:30px">LIHAT MENU LAIN</button></a></center>

    </div>
    </div>
   </div>



    </div>
</div>
<div class="container-komen mt-5 p-5" style="background-color:#fcf5e1;height:fit-content;" id="komen">
    <h4 align="center">Komentar-Komentar pengunjung website</h4>
    <div class="d-flex" style="">
        <div style="min-width: 40%">
                <input placeholder="id struk" type="text" class="form-control">
                <br>
                <textarea placeholder="masukkan komentar anda" name="" class="form-control" id="" cols="30" rows="5"></textarea>
        </div>
        <div>

        </div>
    </div>
</div>
<div class="container-about" style="margin-top: 150px" id="about">
    <div>
        <button><a href="about">MORE ABOUT US</a></button>
    </div>
</div>
@endsection

