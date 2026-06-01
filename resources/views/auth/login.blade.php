@extends('layouts.gym') @section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card bg-dark text-white border-warning shadow-lg mt-5">
                <div class="card-header border-warning text-center fw-bold fs-4">Iniciar Sesión en IronGym</div>

                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-warning fw-bold">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control bg-secondary text-white border-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback text-danger fw-bold"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-warning fw-bold">Contraseña</label>
                            <input id="password" type="password" class="form-control bg-secondary text-white border-0 @error('password') is-invalid @enderror" name="password" required>
                            @error('password')
                                <span class="invalid-feedback text-danger fw-bold"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-warning fw-bold fs-5 text-dark">ENTRAR</button>
                            
                            <div class="d-flex align-items-center my-2">
                                <hr class="flex-grow-1 border-secondary">
                                <span class="mx-2 text-secondary small">O ingresa con</span>
                                <hr class="flex-grow-1 border-secondary">
                            </div>
                            
                            <a href="{{ route('login.google') }}" class="btn btn-light fw-bold text-dark d-flex align-items-center justify-content-center">
    <span class="fs-5 me-2">🌐</span> Continuar con Google
</a>
                           
                        
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection