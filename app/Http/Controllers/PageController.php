<?php

namespace App\Http\Controllers;
use App\Models\{TipeMenu, Menu, Komen, AdminBalasKomen};

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $with = [
            "menu_makanan" => Menu::where("tipe_menu", "makanan")->offset(0)->limit(3)->get(),
            "menu_minuman" => Menu::where("tipe_menu", "minuman")->offset(0)->limit(3)->get(),
            "komen" => Komen::offset(0)->limit(6)->get()
        ];
        return view("home")->with("with", $with);
    }

    public function menu(Request $request)
    {
        $with = [
            "menu" =>$request->tipe == NULL ?  Menu::all() : Menu::where("tipe_menu", $request->tipe)->get(),
        ];
        return view("menu")->with("with", $with);
    }

    public function about()
    {
        return view("about");
    }

    public function komentar()
    {
        $komen = AdminBalasKomen::exists() ? Komen::select('komen.id_komen', 'komen.komen', 'komen.created_at')
        ->distinct('komen.id_komen')
        ->leftJoin('admin_balas_komen', 'komen.id_komen', '!=', 'admin_balas_komen.id_komentar_admin')
        ->whereNotNull('admin_balas_komen.admin_usn')
        ->get() : Komen::all();
        $with = [
            "menu" => Menu::all() ,
            "komentar" => $komen
        ];
        return view("komentar")->with("with", $with);;
    }

    public function post_komentar(Request $request) {
        $validator = Validator::make($request->all(), [
            "is_komen" => "string|required"
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $newKomen = new Komen;
        $newKomen->create([
            "komen" => $request->isi_komen
        ]);

        if($res) {
            return redirect()->back();
        }
    }
}
