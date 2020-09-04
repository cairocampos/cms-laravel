@extends("adminlte::page")

@section("title", "Usuários")

@section("content_header")
    <h1>
        Meus Usuários
        <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Novo Usuário</a>
    </h1>
@endsection

@section("content")
    @if(count($users) > 0)
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a href="{{ route('users.edit', ["user" => $user->id]) }}" class="btn btn-sm btn-info">Editar</a>
                                @if(Auth::id() != $user->id)
                                <form onsubmit="return confirm('Deseja deletar esse usuário ?');" class="d-inline" method="POST" action="{{route("users.destroy", ["user" => $user->id])}}">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-danger">Excluir</a>
                                </form>
                                @else 
                                    <i class="fas fa-check"></i> Você
                                @endif
                                {{-- <a href="{{route("users.destroy", ["user" => $user->id])}}" class="delete__user btn btn-sm btn-danger">Excluir</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>       
    {{$users->links()}}
    @endif    
@endsection


@section("js")
    {{-- <script>
        $(function(){

            $(".delete__user").on("click", function(e){
                e.preventDefault();
                const url = $(this).attr("href");

                fetch(url, {
                    method:"DELETE",
                    headers: {
                        "Content-Type":"application/json"
                    }
                }).then(res => {
                    res.json()
                }).then(result => {
                    console.log(result);
                })
            });

        });
    </script> --}}
@endsection