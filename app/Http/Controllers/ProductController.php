<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    private const CATEGORIES = ['helado', 'topping', 'postre', 'bebida', 'otro'];

    // Listado de productos, agrupado por categoría
    public function index()
    {
        $products = Product::orderBy('category')->orderBy('name')->get()->groupBy('category');

        $lowStockProducts = Product::whereNotNull('stock')
            ->whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('stock', '>', 0)
            ->orderBy('stock')
            ->get();

        $outOfStockProducts = Product::whereNotNull('stock')
            ->where('stock', '<=', 0)
            ->get();

        return view('admin.products.index', compact('products', 'lowStockProducts', 'outOfStockProducts'));
    }

    // Formulario para crear producto
    public function create()
    {
        $categories = self::CATEGORIES;
        return view('admin.products.create', compact('categories'));
    }

    // Guardar producto nuevo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'base_price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'track_stock' => 'sometimes|boolean',
            'stock' => 'nullable|required_if:track_stock,1|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        // Si no se marca "controlar stock", se guarda null (stock ilimitado / no controlado)
        $validated['stock'] = $request->boolean('track_stock') ? $validated['stock'] : null;
        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 5;
        unset($validated['track_stock']);

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto creado correctamente');
    }

    // Formulario para editar producto
    public function edit(Product $product)
    {
        $categories = self::CATEGORIES;
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Actualizar producto (incluye precio y stock)
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'base_price' => 'required|numeric|min:0',
            'track_stock' => 'sometimes|boolean',
            'stock' => 'nullable|required_if:track_stock,1|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
        ]);

        $validated['stock'] = $request->boolean('track_stock') ? $validated['stock'] : null;
        $validated['low_stock_threshold'] = $validated['low_stock_threshold'] ?? 5;
        unset($validated['track_stock']);

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    // Activar / desactivar producto (sin borrarlo, para no romper tickets históricos)
    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $estado = $product->is_active ? 'activado' : 'desactivado';
        return back()->with('success', "Producto {$estado}");
    }

    // Eliminar producto definitivamente
    public function destroy(Product $product)
    {
        // Si el producto ya se usó en algún ticket, mejor desactivarlo que borrarlo,
        // porque order_items tiene product_id con onDelete('set null') y perderíamos
        // la referencia (aunque el nombre queda guardado en product_name como respaldo).
        if ($product->orderItems()->exists()) {
            $product->update(['is_active' => false]);
            return back()->with('error', 'Este producto ya tiene ventas registradas; se desactivó en lugar de eliminarse.');
        }

        $product->delete();

        return back()->with('success', 'Producto eliminado');
    }
}
