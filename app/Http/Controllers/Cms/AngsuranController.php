<?php

namespace App\Http\Controllers\Cms;

use App\Models\Angsuran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AngsuranController extends Controller
{
    public function indexKantor() {
        $angsuran = Angsuran::kantor()->get();
        return view('cms.angsuran.kantor.index', [
            "angsuran" => $angsuran
        ]);
    }

    public function indexKoperasi() {
        $angsuran = Angsuran::koperasi()->get();
        return view('cms.angsuran.koperasi.index', [
            "angsuran" => $angsuran
        ]);
    }

    public function create()
    {
        return view('cms.angsuran.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
