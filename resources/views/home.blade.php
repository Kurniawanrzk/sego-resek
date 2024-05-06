@extends('layouts.master')
@section('content')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="video-container">
                <video style="width: 100%;height:300px" id="qr-video"></video>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="close-modal-camera" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
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
            <div class="menu-makanan">
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
        <div class="menu-minuman">
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
    </div>
    <center><a href="{{Route("menu")}}"><button class="btn btn-light" style="font-size:30px">LIHAT MENU LAIN</button></a></center>

    </div>
   </div>



    </div>
</div>
<div class="container-komen mt-5 p-5" style="background-color:#fcf5e1;height:fit-content;" id="komen">
    <h4 align="center">Komentar-Komentar pengunjung website</h4>

    <div class="d-flex" style="">
        <div style="min-width: 40%">
            <div style="width: 350px;margin-bottom:10px;color:grey">
                <i >Anda dapat mengirimkan komentar/saran secara Anonymouse ke website sego resek. Silahkan scan barcode yang anda dapatkan dari struk pembelian</i>
            </div>
            <div class="d-flex gap-1">
                <button  data-bs-toggle="modal" id="open-camera" data-bs-target="#exampleModal" class="btn btn-light">Kilk Untuk Scan Barcode</button>
                <button style="display: none" id="scan-ulang" class="btn btn-light">Scan Ulang</button>
            </div>
                <form id="form_komentar" method="POST" action="{{Route('post_komentar')}}">
                @csrf
                <input name="token_komentar" id="token_komentar" type="hidden">
                <span id="info"></span>
                <br>
                <textarea placeholder="masukkan komentar anda" name="isi_komen" class="form-control" id="" cols="30" rows="5"></textarea>
                <br>
                <button type="submit" class="btn btn-light">Kirim</button>
                </form>
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
<video></video>

<script src="assets/js/qr-scanner/qr-scanner.umd.min.js"></script>
<script>
    const video = document.getElementById('qr-video');
const videoContainer = document.getElementById('video-container');
const camQrResult = document.getElementById('cam-qr-result');
const btnOpenCamera = document.getElementById('open-camera');
const scanUlang = document.getElementById('scan-ulang');
const info = document.getElementById('info');
const token_komentar = document.getElementById('token_komentar');
let qrDetected = false; // Variable to track if QR code is detected

function setResult(label, result) {
    console.log(result.data);
    label.textContent = result.data;
    token_komentar.value = result.data;
    label.style.color = 'teal';
    clearTimeout(label.highlightTimeout);
    label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
    qrDetected = true; // Set to true once QR code is detected
    scanner.stop(); // Stop scanning once QR code is detected
    btnOpenCamera.className = 'btn btn-success'
    btnOpenCamera.innerText = "Barcode berhasil terscan!"
    document.getElementById("close-modal-camera").click()
    btnOpenCamera.disabled = true
    info.innerText = "Silahkan masukkan isi komen dan submit"
    info.style.color = "gray"
    scanUlang.style.display = "block"
}

const scanner = new QrScanner(video, result => {
    if (!qrDetected) { // Only set result if QR code not detected yet
        setResult(camQrResult, result);
    }
}, {
    onDecodeError: error => {
        if (!qrDetected) { // Only display error if QR code not detected yet
            camQrResult.textContent = error;
            camQrResult.style.color = 'inherit';
        }
    },
    highlightScanRegion: true,
    highlightCodeOutline: true,
});



btnOpenCamera.onclick = function() {
    scanner.start().then(() => {
    QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
        const option = document.createElement('option');
        option.value = camera.id;
        option.text = camera.label;
        camList.add(option);
    }));
});
}

scanUlang.onclick = function() {
    btnOpenCamera.disabled = false
    btnOpenCamera.className = 'btn btn-light'
    btnOpenCamera.innerText = "Klik Untuk Scan Barcode"
    scanUlang.style.display = "none"
    qrDetected = false;

}


</script>
@endsection

