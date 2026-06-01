<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // <-- Librería necesaria para el cadenero

class AdminController extends Controller
{
    // --- ESTE ES EL CADENERO VIP (Seguridad) ---
    public function __construct()
{
    $this->middleware('auth');
    
    $this->middleware(function ($request, $next) {
        $user = Auth::user();
        
        // --- DEPURACIÓN TEMPORAL ---
        // Si ves esto en pantalla al entrar, sabrás qué está pasando
        if (!$user) {
            dd("No hay usuario autenticado");
        }
        
        $admins = ['carloseduardot109@gmail.com', 'gabyrebal23@gmail.com'];

        if (!in_array($user->email, $admins)) {
            // Esto te dirá qué correo está leyendo el sistema realmente
            dd("Correo actual: " . $user->email . " - No autorizado.");
        }
        
        return $next($request);
    });
}

    // Función interna para asegurar que los 20 productos vivan en la memoria persistente
    private function getProductosDeMemoria()
    {
        if (!session()->has('admin_productos')) {
            $iniciales = [
                1 => ['id'=>1, 'nombre'=>'Whey Protein Gold Standard', 'marca'=>'Optimum Nutrition', 'precio'=>1650, 'cat'=>'Proteína', 'imagen'=>'🥛'],
                2 => ['id'=>2, 'nombre'=>'ISO100 Hydrolyzed', 'marca'=>'Dymatize', 'precio'=>1890, 'cat'=>'Proteína', 'imagen'=>'🥛'],
                3 => ['id'=>3, 'nombre'=>'Nitro-Tech 100% Whey', 'marca'=>'MuscleTech', 'precio'=>1450, 'cat'=>'Proteína', 'imagen'=>'🥛'],
                4 => ['id'=>4, 'nombre'=>'Carnivor Beef Protein', 'marca'=>'MuscleMeds', 'precio'=>1300, 'cat'=>'Proteína', 'imagen'=>'🥛'],
                5 => ['id'=>5, 'nombre'=>'C4 Original', 'marca'=>'Cellucor', 'precio'=>650, 'cat'=>'Pre-entreno', 'imagen'=>'⚡'],
                6 => ['id'=>6, 'nombre'=>'Psychotic', 'marca'=>'Insane Labz', 'precio'=>750, 'cat'=>'Pre-entreno', 'imagen'=>'⚡'],
                7 => ['id'=>7, 'nombre'=>'N.O.-Xplode', 'marca'=>'BSN', 'precio'=>800, 'cat'=>'Pre-entreno', 'imagen'=>'⚡'],
                8 => ['id'=>8, 'nombre'=>'Creatina Monohidratada', 'marca'=>'Platinum', 'precio'=>550, 'cat'=>'Creatina', 'imagen'=>'🧪'],
                9 => ['id'=>9, 'nombre'=>'Creatine Drive', 'marca'=>'Nutrex', 'precio'=>600, 'cat'=>'Creatina', 'imagen'=>'🧪'],
                10=> ['id'=>10, 'nombre'=>'Xtend BCAA', 'marca'=>'Scivation', 'precio'=>700, 'cat'=>'Aminoácidos', 'imagen'=>'🧬'],
                11=> ['id'=>11, 'nombre'=>'Amino Energy', 'marca'=>'Optimum Nutrition', 'precio'=>680, 'cat'=>'Aminoácidos', 'imagen'=>'🧬'],
                12=> ['id'=>12, 'nombre'=>'Quest Protein Bar (Caja x12)', 'marca'=>'Quest Nutrition', 'precio'=>850, 'cat'=>'Barras', 'imagen'=>'🍫'],
                13=> ['id'=>13, 'nombre'=>'One Bar Peanut Butter (Caja x12)', 'marca'=>'One Brands', 'precio'=>800, 'cat'=>'Barras', 'imagen'=>'🍫'],
                14=> ['id'=>14, 'nombre'=>'The Complete Cookie (Caja x12)', 'marca'=>'Lenny & Larrys', 'precio'=>750, 'cat'=>'Snacks', 'imagen'=>'🍪'],
                15=> ['id'=>15, 'nombre'=>'L-Carnitine 3000', 'marca'=>'GAT Sport', 'precio'=>450, 'cat'=>'Quemadores', 'imagen'=>'🔥'],
                16=> ['id'=>16, 'nombre'=>'Multivitamínico Opti-Men', 'marca'=>'Optimum Nutrition', 'precio'=>500, 'cat'=>'Vitaminas', 'imagen'=>'💊'],
                17=> ['id'=>17, 'nombre'=>'Multivitamínico Opti-Women', 'marca'=>'Optimum Nutrition', 'precio'=>500, 'cat'=>'Vitaminas', 'imagen'=>'💊'],
                18=> ['id'=>18, 'nombre'=>'Shaker BlenderBottle 28oz', 'marca'=>'Iron Gym', 'precio'=>250, 'cat'=>'Accesorios', 'imagen'=>'🥤'],
                19=> ['id'=>19, 'nombre'=>'Straps para Levantamiento', 'marca'=>'Iron Gym', 'precio'=>200, 'cat'=>'Accesorios', 'imagen'=>'💪'],
                20=> ['id'=>20, 'nombre'=>'Cinturón de Halterofilia de Cuero', 'marca'=>'Iron Gym', 'precio'=>950, 'cat'=>'Accesorios', 'imagen'=>'🪨'],
            ];
            session()->put('admin_productos', $iniciales);
        }
        return session()->get('admin_productos');
    }

    // Muestra el inventario desde la memoria
    public function index()
    {
        $productos = $this->getProductosDeMemoria();
        return view('admin.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.create');
    }

    // Guarda un producto nuevo de verdad en la memoria
    public function store(Request $request)
    {
        $productos = $this->getProductosDeMemoria();
        
        // Generar un ID nuevo automáticamente
        $nuevoId = count($productos) > 0 ? max(array_keys($productos)) + 1 : 1;

        $productos[$nuevoId] = [
            'id' => $nuevoId,
            'nombre' => $request->nombre,
            'marca' => $request->marca,
            'precio' => $request->precio,
            'cat' => $request->cat,
            'imagen' => $request->imagen ?? '📦'
        ];

        session()->put('admin_productos', $productos);
        return redirect()->route('admin.index')->with('success', '¡Producto registrado con éxito!');
    }

    // Busca el producto exacto para rellenar el formulario
    public function edit($id)
    {
        $productos = $this->getProductosDeMemoria();
        $producto = $productos[$id] ?? null;
        
        if (!$producto) return redirect()->route('admin.index');
        return view('admin.create', compact('producto'));
    }

    // Reemplaza los datos viejos por los nuevos en la memoria
    public function update(Request $request, $id)
    {
        $productos = $this->getProductosDeMemoria();

        if (isset($productos[$id])) {
            $productos[$id]['nombre'] = $request->nombre;
            $productos[$id]['marca'] = $request->marca;
            $productos[$id]['precio'] = $request->precio;
            $productos[$id]['cat'] = $request->cat;
            $productos[$id]['imagen'] = $request->imagen;

            session()->put('admin_productos', $productos);
        }

        return redirect()->route('admin.index')->with('success', '¡Producto actualizado correctamente!');
    }

    // Elimina el producto por completo de la memoria
    public function destroy($id)
    {
        $productos = $this->getProductosDeMemoria();

        if (isset($productos[$id])) {
            unset($productos[$id]);
            session()->put('admin_productos', $productos);
        }

        return redirect()->route('admin.index')->with('success', '¡Producto eliminado del inventario!');
    }

    public function usuarios()
    {
        $usuarios = User::all();
        return view('admin.usuarios', compact('usuarios'));
    }
}