@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row recent-menu">
        <div class="col">{{ auth()->user()}}
            <h4>Menu</h4>
            <a href="{{ Route("admin_add_menu") }}"><button class="btn btn-primary">Tambah Baru +</button></a>
            <a href="{{Route("get_all_menu")}}"><button class="btn btn-primary">Lihat Semua Menu</button></a>
            <div class="row mt-3 d-flex">
                    @if(count($with['menu']))
                    @foreach ( $with['menu'] as $menu)
                    <div class="col-lg-4 mb-4">
                        <div class="card" style="width: 18rem;">
                            <img src="{{$menu->file_foto}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{$menu->nama_menu}}</h5>
                                <h6 class="">Rp.{{$menu->harga_menu}}</h6>
                                <p class="card-text">{{$menu->deskripsi}}</p>
                                <div class="d-flex gap-1">
                                    <a href="{{Route('admin_update_menu', $menu->id_menu)}}" class="btn btn-success">Perbarui</a>
                                    <form id="delete-form" action="{{ route('delete_menu', $menu->id_menu) }}" method="post">
                                        @csrf
                                        @method("delete")
                                        <button id="hapus-btn" class="delete-btn btn btn-danger" type="button">Hapus</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h3 align="center">Belum ada Data</h3>
                    @endif
                <script>
                    // Assign event listeners to each delete button
                    const deleteButtons = document.querySelectorAll(".delete-btn");

                    deleteButtons.forEach(button => {
                        button.addEventListener("click", function(event) {
                            event.preventDefault(); // Prevent form submission

                            // Show confirmation dialog
                            Swal.fire({
                                title: 'Apakah Anda yakin ingin menghapus?',
                                text: "Anda tidak akan dapat mengembalikannya!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, hapus!',
                                cancelButtonText: 'Batal'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // If confirmed, submit the form associated with the clicked button
                                    button.closest('form').submit();
                                }
                            });
                        });
                    });
                </script>
            </div>
        </div>
    </div>
    <div class="row recent-saran">
        <div class="col">
            <h4>Komentar Dari Pengunjung Website</h4>
            <a href="{{Route("get_all_komen")}}"><button class="btn btn-primary">Lihat Semua Komen</button></a>
            <div class="col">
                @if (count($with["komen"]))
                @foreach ( $with["komen"] as $komen)
                <div class="col shadow-sm border mt-2 p-2">
                  <div class="d-flex align-items-center justify-content-between">
                     <div class="col-10">
                        <p>{{$komen->komen}}</p>
                     </div>
                     <div class="col-1">
                        <p style="color:blue">{{ \Carbon\Carbon::parse($komen->created_at)->diffForHumans() }}</p>
                     </div>
                  </div>
                  <div class="col">
                      <form action="{{Route("delete_komen", $komen->id_komen)}}" id="delete-form-komen" method="post">
                          @csrf
                          @method("delete")
                          <button class="btn delete-btn-komen" type="submit"><span style="color:gray">Remove</span></button>
                      </form>
                  </div>
                </div>
                @endforeach
                @else
                <h3 align="center">Belum Ada Data</h3>
                @endif
              <script>
                // Assign event listeners to each delete button
                const deleteButtonsKomen = document.querySelectorAll(".delete-btn-komen");

                deleteButtonsKomen.forEach(button => {
                    button.addEventListener("click", function(event) {
                        event.preventDefault(); // Prevent form submission

                        // Show confirmation dialog
                        Swal.fire({
                            title: 'Apakah Anda yakin ingin menghapus?',
                            text: "Anda tidak akan dapat mengembalikannya!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // If confirmed, submit the form associated with the clicked button
                                button.closest('form').submit();
                            }
                        });
                    });
                });
            </script>
            </div>
        </div>
    </div>
</div>
@endsection
