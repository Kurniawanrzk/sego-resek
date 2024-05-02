<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Session, Validator,File, Storage};
use App\Models\{TipeMenu, Menu, Komen, AdminBalasKomen};

class AdminsController extends Controller
{
    public function get_login(Request $request) {
        if (Auth::guard('admin')->user()) {
            return redirect()->route('admin_dashboard')->with('success','You are Logged in sucessfully.');
        }
        return view('admin.login');
    }

    public function post_login(Request $request) {

        if(auth()->guard('admin')->attempt(['username' => $request->input('username'),  'password' => $request->input('password')])){
            $user = auth()->guard('admin')->user();
            if($user){
                return redirect()->route('admin_dashboard')->with('success','You are Logged in sucessfully.');
            }
        }else {
            return back()->with('error','Whoops! invalid username and password.');
        }
    }

    public function get_all_menu() {
        $with = [
            "data_menu" => Menu::all()
        ];
        return view('admin.menu')->with("with", $with);
    }

    public function admin_dashboard(Request $request) {
        $komen = AdminBalasKomen::exists() ? Komen::select('komen.id_komen', 'komen.komen', 'komen.created_at')
        ->distinct('komen.id_komen')
        ->leftJoin('admin_balas_komen', 'komen.id_komen', '!=', 'admin_balas_komen.id_komentar_admin')
        ->whereNotNull('admin_balas_komen.admin_usn')
        ->offset(0)
        ->limit(6)
        ->get() : Komen::all();
        $with = [
            "success" => "You are Logged in sucessfully.",
            "menu" => Menu::offset(0)->limit(6)->get(),
            "komen" =>$komen
        ];
        return view('admin.dashboard')->with("with",$with);
    }
    public function admin_logout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('admin_login_get'));
    }

    public function admin_add_menu() {
        $with = [
            "method" => "post"
        ];
        return view('admin.add_menu')->with("with", $with);
    }

    public function admin_menu_post(Request $request) {
        $validator = Validator::make($request->all(), [
            "nama_menu" => "string|required",
            "harga_menu" => "string|required",
            "tipe_menu" => "string|required",
            "deskripsi" => "string|required",
            "foto" => "required"
        ]);

        if($validator->fails()) {
            return back()->with('error','Masukkan Seluruh Field Secara lengkap');
        }

        if($request->hasFile("foto")) {
            $img = $request->file("foto");
            try {
                $nama_foto = $request->nama_menu . "-" . $request->tipe_menu . "." . $img->getClientOriginalExtension();
                $img->move(public_path("uploads/menu_foto/"), $nama_foto);
                $menu_baru = new Menu;
                unset($request->file_foto);
                $request->merge(["file_foto" => asset("uploads/menu_foto/$nama_foto"), "tipe_menu" => $request->tipe_menu]);
                $menu_baru->fill($request->all());
                $menu_baru->save();
                return redirect()->route("admin_dashboard");
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function admin_update_menu($id) {
        $data_menu = Menu::where("id_menu",$id)->first();
        $with = [
            "data_menu" => $data_menu,
            "method" => "put"
        ];
        return view('admin.add_menu')->with("with", $with);
    }

    public function admin_menu_put($id, Request $request) {
        $validator = Validator::make($request->all(), [
            "nama_menu" => "string|required",
            "harga_menu" => "string|required",
            "tipe_menu" => "string|required",
            "deskripsi" => "string|required",
        ]);

        if($validator->fails()) {
            return back()->with('error','Masukkan Seluruh Field Secara lengkap');
        }
        $perbarui_menu = Menu::where("id_menu",$id)->first();
        if($request->hasFile("foto")) {
            $fileToDelete = parse_url($perbarui_menu->file_foto, PHP_URL_PATH);
            File::delete(public_path($fileToDelete));
            $img = $request->file("foto");
            $nama_foto = $request->nama_menu . "-" . $request->tipe_menu . "." . $img->getClientOriginalExtension();
            $img->move(public_path("uploads/menu_foto/"), $nama_foto);
            $request->merge(["file_foto" => asset("uploads/menu_foto/$nama_foto"), "tipe_menu" => $request->tipe_menu]);
            unset($request->file_foto);
        } else {
            $request->merge(["tipe_menu" => $request->tipe_menu]);
        }
                $perbarui_menu->update($request->all());
                $perbarui_menu->save();
                return redirect()->route("admin_dashboard");


    }

    public function delete_menu($id) {
        $menu = Menu::destroy($id);
        if($menu) {
            return back()->with("success". "Berhasil menghapus menu");
        }
    }

    public function get_all_komen() {
        $komen = AdminBalasKomen::exists() ? Komen::select('komen.id_komen', 'komen.komen', 'komen.created_at')
        ->distinct('komen.id_komen')
        ->leftJoin('admin_balas_komen', 'komen.id_komen', '!=', 'admin_balas_komen.id_komentar_admin')
        ->whereNotNull('admin_balas_komen.admin_usn')
        ->get() : Komen::all();
        $with = [
            "komen" =>$komen,
            "menu" => Menu::all()
        ];
        return view('admin.komen')->with("with", $with);
    }
    public function delete_komen($id) {
        $komen = Komen::destroy($id);
        if($komen) {
            return back()->with("success". "Berhasil menghapus komen");
        }
    }

    public function admin_post_komen(Request $request) {
        $newBalasanKomen = new Komen;
        $res = $newBalasanKomen->create([
            "komen" => $request->isi_komen,
            "created_at" => date("Y-m-d H:i:s")
        ]);

        $newBalasan = new AdminBalasKomen;
        $newBalasan->create([
            "admin_usn" => auth()->guard("admin")->user()->username,
            "id_komentar_admin" => $res->id_komen,
            "id_komentar_pengunjung" => $request->id_komentar_pengunjung,
            "id_menu" => $request->id_menu
        ]);

        if($newBalasan) {
            return back()->with("success". "Berhasil membalas komen");
        }

    }
}
