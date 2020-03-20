@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ request()->url() }}" class="row">
                        <div class="col-md-3">
                            <input type="text" name="q" id="q" class="form-control" placeholder="Buscar usuário" value="{{ request('q') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="status" id="status" class="custom-select">
                                <option value="">Todos</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Ativo</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-outline-primary uppercase">Buscar</button>
                        </div>

                        <div class="col-md-3 text-right">
                            <a href="{{ route('users.create') }}" class="btn btn-outline-secondary uppercase">Criar Usuário</a>
                        </div>
                    </form>

                    <hr>

                    <div class="bg-white">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="badge badge-{{ $user->active ? 'success' : 'danger' }}">{{ $user->active ? 'Ativo' : 'Inativo' }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('users.edit', $user) }}" class="btn btn-outline-info btn-sm mr-2">Editar</a>

                                                @if ($user->active)
                                                    <form action="{{ route('users.deactivate', $user) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button class="btn btn-outline-danger btn-sm">Inativar</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('users.activate', $user) }}" method="POST">
                                                        @csrf

                                                        <button class="btn btn-outline-success btn-sm">Ativar</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex align-items-center justify-content-center">
                        {{ $users->appends(request()->query()) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
