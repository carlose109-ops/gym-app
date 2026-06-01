@extends('layouts.gym')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-warning">Control de Miembros Registrados</h2>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary fw-bold px-4">Volver al Inventario</a>
    </div>

    <div class="card bg-dark text-white border-secondary shadow">
        <div class="card-header border-secondary fw-bold text-warning fs-5 bg-black py-3">
            👥 Usuarios de IronGym
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-striped align-middle m-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha de Registro</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                            <tr>
                                <td class="fw-bold text-secondary">#{{ $user->id }}</td>
                                <td class="fw-bold text-white">{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="text-center"><span class="badge bg-success">Activo</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection