@extends('layouts.auth')

@section('content')
    <h5 class="card-title text-center">Bem vindo de volta!</h5>

    <form class="form-signin" action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form-label-group">
            <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" value="{{ old('email') }}" required autofocus>
            <label for="email">E-mail</label>
            {!! $errors->first('email', '<span class="text-danger text-sm mt-1">:message</span>') !!}
        </div>


        <div class="form-label-group">
            <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required>
            <label for="password">Senha</label>

            {!! $errors->first('email', '<span class="text-danger text-sm mt-1">:message</span>') !!}
        </div>

        <input type="hidden" name="remember" id="remember" value="true" />

        <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Acessar</button>
    </form>
@endsection
