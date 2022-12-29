@extends('categorie.layout')
 
@section('content')
    <div class="row" style="margin-top: 5rem;">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Gestione Categorie</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('categorie.create') }}"> Nuova Categoria</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Categoria</th>
            <th>Colore</th>
            <th>Codice</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->categoria }}</td>
            <td>{{ $value->codice }}</td>
            <td>{{ $value->colore }}</td>
            <td>
                <form action="{{ route('categorie.destroy',$value->id) }}" method="POST">   
                    <a class="btn btn-info" href="{{ route('categorie.show',$value->id) }}">Vedi</a>    
                    <a class="btn btn-primary" href="{{ route('categorie.edit',$value->id) }}">Modifica</a>   
                    @csrf
                    @method('DELETE')      
                    <button type="submit" class="btn btn-danger">Elimina</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>  
    {!! $data->links() !!}   
    <div>Showing {{($data->currentpage()-1)*$data->perpage()+1}} to {{$data->currentpage()*$data->perpage()}}
    of  {{$data->total()}} entries
</div>
@endsection