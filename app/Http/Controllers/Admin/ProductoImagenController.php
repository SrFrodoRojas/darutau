<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductoImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoImagenController extends Controller
{
    public function store(Request $request, Producto $producto)
    {
        $request->validate([
            'imagen' => 'required|image|max:2048',
            'alt_text' => 'nullable|string',
        ]);

        $path = $request->file('imagen')->store('productos', 'public');

        $imagen = $producto->imagenes()->create([
            'ruta' => $path,
            'alt_text' => $request->alt_text,
            'orden' => $producto->imagenes()->count() + 1,
            'principal' => $producto->imagenes()->count() == 0,
        ]);

        return response()->json(['success' => true, 'imagen' => $imagen]);
    }

    public function destroy(ProductoImagen $imagen)
    {
        Storage::disk('public')->delete($imagen->ruta);
        $imagen->delete();
        return response()->json(['success' => true]);
    }

    public function setPrincipal(ProductoImagen $imagen)
    {
        // Quitar principal de otras imágenes del mismo producto
        $imagen->producto->imagenes()->update(['principal' => false]);
        $imagen->principal = true;
        $imagen->save();
        return response()->json(['success' => true]);
    }
}
