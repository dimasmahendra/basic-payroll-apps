<?php

namespace App\Http\Controllers\Cms;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JabatanController extends Controller
{
    public function index() {
        $jabatan = Jabatan::get();
        return view('cms.jabatan.index', [
            "jabatan" => $jabatan
        ]);
    }

    public function create()
    {
        return view('cms.jabatan.create');
    }

    public function store(Request $request)
    {
        $model = new Jabatan;
        $model->nama = $request->nama;
        $model->save();
        return redirect(route('jabatan'))->with("message", "Berhasil Simpan");
    }

    public function edit($id)
    {
        $jabatan = Jabatan::find($id);
        return view('cms.jabatan.edit', [
            "id" => $id,
            "jabatan" => $jabatan
        ]);
    }

    public function update(Request $request, $id)
    {
        $model = Jabatan::find($id);
        $model->nama = $request->nama;
        $model->save();
        return redirect(route('jabatan'))->with("message", "Berhasil Update");
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();
        return redirect(route('jabatan'))->with("message", "Berhasil Hapus Data");
    }
}
