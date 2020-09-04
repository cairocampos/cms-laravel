@extends("adminlte::page")

@section("title", "Usuários")

@section("content_header")
    <h1>Novo Usuário</h1>
@endsection

@section("content")

@if($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            <h5><i class="icon fas fa-ban"></i> Ocorreu um erro.</h5>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        </ul>
    </div>
@endif


<div class="card">
    <div class="card-body">
        <form action="{{route('users.store')}}" method="POST" class="form-horizontal">
            @csrf
            <div class="box-body">
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Nome Completo</label>    
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name')}}">
                    </div>
                  </div>
              <div class="form-group row">
                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                  <div class="col-sm-10">
                      <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{old('email')}}">
                  </div>
              </div>
              <div class="form-group row">
                  <label for="password" class="col-sm-2 col-form-label">Senha</label>
                  <div class="col-sm-10">
                      <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                  </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <label for="password_confirmation" class="col-sm-2 col-form-label">Confirme a Senha</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-sm-2"></label>
                <div class="col-sm-10">
                    <input type="submit" value="Cadastrar" class="btn btn-success">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection