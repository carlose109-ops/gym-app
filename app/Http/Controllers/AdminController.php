<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Constructor con seguridad: solo permite acceso a los correos autorizados.
     */
    public function __construct()
    {
        // 1. Obligar a estar logueado
        $this->middleware('auth');

        // 2. Verificar que sea uno de los administradores
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $admins = ['carloseduardot109@gmail.com', 'gabyrebal23@gmail.com'];

            if (!in_array($user->email, $admins)) {
                return redirect('/')->with('error', 'No tienes permisos de administrador.');
            }

            return $next($request);
        });
    }

    /**
     * Obtiene los productos desde la sesión (memoria).
     */
    private function getProductosDeMemoria()
    {
        if (!session()->has('admin_productos')) {
            // Datos iniciales si la sesión está vacía
            $productos = [
                1 => ['id'=>1, 'nombre'=>'Whey Protein Gold Standard', 'marca'=>'Optimum Nutrition', 'precio'=>1650, 'cat'=>'Proteína', 'imagen'=>'🥛'],
                2 => ['id'=>2, 'nombre'=>'ISO100 Hydrolyzed', 'marca'=>'Dymatize', 'precio'=>1890, 'cat'=>'Proteína', 'imagen'=>'🥛'],
                // ... (puedes añadir aquí los demás que tenías)
            ];
            session()->put('admin_productos', $productos);
        }
        return session()->get('admin_productos');
    }

    public function index()
    {
        $productos = $this->getProductosDeMemoria();
        $totalProductos = count($productos);
        $valorInventario = array_sum(array_column($productos, 'precio'));
        $precioPromedio = $totalProductos > 0 ? $valorInventario / $totalProductos : 0;

        return view('admin.index', compact('productos', 'totalProductos', 'valorInventario', 'precioPromedio'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $productos = $this->getProductosDeMemoria();
        $id = count($productos) + 1;
        
        $productos[$id] = [
            'id' => $id,
            'nombre' => $request->nombre,
            'marca'  => $request->marca,
            'precio' => $request->precio,
            'cat'    => $request->cat,
            'imagen' => '📦' // Icono por defecto
        ];

        session()->put('admin_productos', $productos);
        return redirect()->route('admin.index')->with('success', 'Producto agregado correctamente.');
    }

    public function edit($id)
    {
        $productos = $this->getProductosDeMemoria();
        $producto = $productos[$id] ?? null;

        if (!$producto) return redirect()->route('admin.index');
        return view('admin.create', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $productos = $this->getProductosDeMemoria();
        if (isset($productos[$id])) {
            $productos[$id]['nombre'] = $request->nombre;
            $productos[$id]['marca']  = $request->marca;
            $productos[$id]['precio'] = $request->precio;
            $productos[$id]['cat']    = $request->cat;
            session()->put('admin_productos', $productos);
        }
        return redirect()->route('admin.index')->with('success', 'Producto actualizado.');
    }

    public function destroy($id)
    {
        $productos = $this->getProductosDeMemoria();
        if (isset($productos[$id])) {
            unset($productos[$id]);
            session()->put('admin_productos', $productos);
        }
        return redirect()->route('admin.index')->with('success', 'Producto eliminado.');
    }

    public function usuarios()
    {
        $usuarios = User::all();
        return view('admin.usuarios', compact('usuarios'));
    }
}