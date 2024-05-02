@extends('layouts.master')
@section('content')
<div
style="position:absolute;width:100%;height:100vh;background-color:rgba(0, 0, 0, 0.174);display:none"
class="insert-komentar">

</div>
<div class="container-komen mt-5 p-5"  id="komen">
    <h4 align="center">Komentar-Komentar pengunjung website</h4>
    <button class="btn btn-light ms-5">Tambah Komentar</button>
    <div class="d-grid justify-content-around mt-3 gap-3" style="grid-template-columns:auto auto auto;">
        @foreach ($with["komentar"] as $item )
            <div class="bg-light p-3 rounded shadow " style="width:300px;height:fit-content">
                <p>{{$item->komen}}</p>
                <p style="color:rgb(103, 103, 194)">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>

            </div>
        @endforeach
    </div>
</div>
<script>

</script>
@endsection

