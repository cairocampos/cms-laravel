@extends("adminlte::page")

@section("title", "nova Página")

@section("content_header")
    <h1>Nova Página</h1>
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
        <form action="{{route('pages.store')}}" method="POST" class="form-horizontal">
            @csrf
            <div class="box-body">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Titulo</label>    
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title')}}">
                    </div>
                  </div>
              <div class="form-group row">
                  <label for="body" class="col-sm-2 col-form-label">Corpo</label>
                  <div class="col-sm-10">
                      <textarea cols="30" rows="10" class="form-control @error('body') is-invalid @enderror" name="body" id="body" value="{{ old('body') }}"></textarea>                  
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