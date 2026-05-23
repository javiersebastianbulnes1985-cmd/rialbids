<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gasto;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "concepto" => "required|string",
            "monto"    => "required|numeric|min:0",
            "mes"      => "required|string",
            "notas"    => "nullable|string",
        ]);
        Gasto::create($request->all());
        return redirect()->route("admin.finanzas")->with("success", "Gasto registrado.");
    }

    public function destroy($id)
    {
        Gasto::findOrFail($id)->delete();
        return redirect()->route("admin.finanzas")->with("success", "Gasto eliminado.");
    }
}
