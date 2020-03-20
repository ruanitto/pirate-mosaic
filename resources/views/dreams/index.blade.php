@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form action="{{ request()->url() }}" class="row">
                        <div class="col-md-4">
                            <input type="search" name="q" id="q" placeholder="Buscar por nome, email ou cpf" class="form-control" value="{{ request('q') }}" />
                        </div>

                        <div class="col-md-4">
                            <select name="cargo" id="cargo" class="custom-select">
                                <option value default>Selecione um cargo</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->cargo }}" {{ $position->cargo == request('cargo') ? 'selected' : '' }}>{{ $position->cargo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex justify-content-between">
                            <button class="btn btn-outline-primary">Buscar</button>

                            <a href="{{ route('export') }}" class="btn btn-outline-info">Exportar</a>
                        </div>
                    </form>

                    <table class="table table-striped mt-4">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>E-mail</th>
                                <th>Cargo</th>
                                <th>Ação</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($dreams as $dream)
                                <tr>
                                    <th>{{ $dream->employee_nome }}</th>
                                    <th>{{ $dream->employee_cpf }}</th>
                                    <th>{{ $dream->employee_email }}</th>
                                    <th>{{ $dream->employee_position }}</th>
                                    <th>
                                        <a href="{{ route('registers.show', $dream->id) }}" class="btn btn-sm btn-outline-info">Visualizar</a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4 d-flex align-items-center justify-content-center">
                        {{ $dreams->appends(request()->query())->links()  }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
