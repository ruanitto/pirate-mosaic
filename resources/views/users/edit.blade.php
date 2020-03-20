@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1>Editar {{ $user->name }}</h1>

                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @include('users._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
