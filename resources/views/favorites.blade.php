@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Favorites Funds</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Fund Name</th>
                    <th scope="col">Fund Category Name</th>
                    <th scope="col">Fund Sub Category Name</th>
                    <th scope="col">ISIN</th>
                    <th scope="col">WKN</th>
                    <th scope="col">Delete</th>
                    <th scope="col">PDF</th>
                    <th scope="col">XLSX</th>
                    <th scope="col">XML</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($favorites as $favorite)
                    <tr>
                        <td>{{ $favorite->id }}</td>
                        <td>{{ $favorite->name }}</td>
                        <td>{{ $favorite->fundCategory->name }}</td>
                        <td>{{ $favorite->fundSubCategory->name  }}</td>
                        <td>{{ $favorite->ISIN }}</td>
                        <td>{{ $favorite->WKN }}</td>
                        <form action="{{ route('remove', ['id'=>$favorite->id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <td><button type="submit" class="btn btn-danger">Remove</button></td>
                        </form>
                        <td><a href="{{ route('downloadPdf', ['id'=>$favorite->id]) }}">Download</a></td>
                        <td><a href="{{ route('downloadXlsx', ['id'=>$favorite->id]) }}">Download</a></td>
                        <td><a href="{{ route('downloadXml', ['id'=>$favorite->id]) }}">Download</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
