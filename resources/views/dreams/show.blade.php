@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto">
            <a href="{{ route('registers') }}">&larr; Voltar para cadastros</a>
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <small class="d-block text-muted">Nome</small>
                            {{ $dream->employee->nome }}
                        </div>
                        <div class="col-md-4">
                            <small class="d-block text-muted">CPF</small>
                            {{ $dream->employee->cpf }}
                        </div>
                        <div class="col-md-4">
                            <small class="d-block text-muted">E-mail</small>
                            {{ $dream->employee->email }}
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-4">
                            <small class="d-block text-muted">Cargo</small>
                            {{ $dream->employee->cargo }}
                        </div>
                        <div class="col-md-4">
                            <small class="d-block text-muted">Regional</small>
                            {{ $dream->employee->regional }}
                        </div>
                    </div>

                    <hr>

                    <div class="card mt-4">
                        <div class="card-header">Sonho realizado</div>
                        <div class="card-body">
                            {{ $dream->realized }}
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">Proximo sonho</div>
                        <div class="card-body">
                            {{ $dream->realize }}
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-center mt-5">
                        <img src="{{ $dream->imageUrl }}" alt="{{ $dream->employee->nome }}" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
