@extends('layouts.master')

@section('main')

<h1>All funds</h1>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('welcome') }}" method="GET">
                <div class="form-control">
                    <input type="text" name="search" placeholder="Search by Fund Name, ISIN, or WKN" class="form-control" value="{{ request('search_term') }}">
                </div>
                <button type="submit" class="btn btn-success form-control mt-2">Search</button>
            </form>
            <div class="container mt-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fund Name</th>
                            <th scope="col">ISIN</th>
                            <th scope="col">WKN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funds as $fund)
                            <tr>
                                <td>{{ $fund->id }}</td>
                                <td>{{ $fund->name }}</a></td>
                                <td>{{ $fund->ISIN }}</td>
                                <td>{{ $fund->WKN }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $funds->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    
@endsection