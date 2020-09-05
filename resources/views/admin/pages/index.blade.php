@extends("adminlte::page")

@section("title", "Páginas")

@section("content_header")
    <h1>
        Minhas Páginas
        <a href="{{ route('pages.create') }}" class="btn btn-sm btn-success">Nova Página</a>
    </h1>
@endsection

@section("content")
    @if(count($pages) > 0)
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <th width="50">#</th>
                    <th>Titulo</th>
                    <th width="130">Ações</th>
                </thead>
                <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>{{$page->id}}</td>
                            <td>{{$page->title}}</td>
                            <td>
                                <a href="{{ route("pages.show", ["page" => $page->id]) }}" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('pages.edit', ["page" => $page->id]) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-edit"></i>
                                </a>                                
                                <form onsubmit="return confirm('Deseja deletar essa página ?');" class="d-inline" method="POST" action="{{route("pages.destroy", ["page" => $page->id])}}">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>       
    {{$pages->links()}}
    @else
        Nenhuma página adicionada
    @endif    
@endsection