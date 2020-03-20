@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Criar usuário</h1>

                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        @include('users._form', [
                            'user' => new \App\User,
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
