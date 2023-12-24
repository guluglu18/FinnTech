@extends('layouts.app')


@section('content')
<div class="container">
    <h1>All funds</h1>
    <div class="row">
        <div class="col-3 bg-secodary">
            <ul class="list-group list-group-flush"> 

                <li class="list-group-item list-group-item-danger"> 
                    <a href="{{ route('favorites') }}" class="btn btn-primary form-control">Favorites</a>   
                </li>

                <li class="list-group-item list-group-item-success">
                    <form action="{{ route('home') }}" method="GET">
                        <select name="cat" id="" class="form-control">
                            <option value="" disabled selected hidden>Choose a category...</option>
                            @foreach ($fundCategories as $category)
                                <option value="{{ $category->id }}" {{(isset(request()->cat) && request()->cat == $category->id) ? 'selected' : ''}}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success form-control mt-2">Search</button>
                    </form>
                </li>
                <li class="list-group-item list-group-item-success">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="form-control">
                            <input type="text" name="search" placeholder="Search by Fund Name, ISIN, or WKN" class="form-control" value="{{ request('search_term') }}">
                        </div>
                        <button type="submit" class="btn btn-success form-control mt-2">Search</button>
                    </form>
                </li>
            </ul>
        </div>
        <div class="col-9">
            <div class="container mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fund Name</th>
                            <th scope="col">Fund Category Name</th>
                            <th scope="col">Fund Sub Category Name</th>
                            <th scope="col">ISIN</th>
                            <th scope="col">WKN</th>
                            <th scope="col">Favorites</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funds as $fund)
                            <tr>
                                <td>{{ $fund->id }}</td>
                                <td><a href="">{{ $fund->name }}</a></td>
                                <td>{{ $fund->fundCategory->name }}</td>
                                <td>{{ $fund->fundSubCategory->name }}</td>
                                <td>{{ $fund->ISIN }}</td>
                                <td>{{ $fund->WKN }}</td>
                                <form action="{{ route('addToFavorites', ['id'=>$fund->id]) }}" method="POST">
                                    @csrf
                                    <td><button type="submit" class="btn btn-warning add-to-favorites-btn">Add</button></td>
                                </form>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="d-flex justify-content-center">
                    {{ $funds->appends(request()->input())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function () {
    var addToFavoritesButtons = document.querySelectorAll('.add-to-favorites-btn');

    addToFavoritesButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            console.log('kliknuo')
            button.disabled = true;
        });
    });
});
</script> --}}

    
@endsection