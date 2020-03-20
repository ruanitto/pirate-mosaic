<div class="row mb-2">
    <div class="col-md-3">
        <label for="name">Nome</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
    </div>

    <div class="col-md-3">
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
    </div>

    <div class="col-md-3">
        <label for="password">Senha</label>
        <input type="text" name="password" id="password" class="form-control">
    </div>

    <div class="col-md-3">
        <label for="password_confirmation">Confirmação de senha</label>
        <input type="text" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
</div>

<div class="text-right mt-4">
    <button class="btn btn-outline-primary">Salvar</button>
</div>

