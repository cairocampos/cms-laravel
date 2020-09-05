@extends("adminlte::page")

@section("title", "Configurações")

@section("content_header")
    <h1>Configurações do Site</h1>
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
        <form action="{{route('settings.update')}}" method="POST" class="form-horizontal">
            @csrf
            @method('PUT')
            <div class="box-body">
                <div class="form-group row">
                    <label for="title" class="col-sm-2 col-form-label">Titulo do Site</label>    
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                    </div>
                </div>  
                <div class="form-group row">
                    <label for="subtitle" class="col-sm-2 col-form-label">Subtitulo do Site</label>    
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle">
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">E-mail para contato</label>    
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="bgcolor" class="col-sm-2 col-form-label">Cor do fundo</label>    
                    <div class="col-sm-10">
                        <input type="color" class="form-control @error('bgcolor') is-invalid @enderror" id="bgcolor" name="bgcolor">
                    </div>
                </div> 
                <div class="form-group row">
                    <label for="textcolor" class="col-sm-2 col-form-label">Cor do texto</label>    
                    <div class="col-sm-10">
                        <input type="color" class="form-control @error('textcolor') is-invalid @enderror" id="textcolor" name="textcolor">
                    </div>
                </div> 
                 
                <div class="form-group row">
                    <label for="" class="col-sm-2 col-form-label"></label>
                    <input type="submit" value="Salvar" class="btn btn-success">
                </div>            
            </div>
        </form>
    </div>
</div>


@endsection