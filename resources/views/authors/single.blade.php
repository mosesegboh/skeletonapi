@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Author
                        <a href="{{route('home')}}" title="Add book"><i class="bi bi-arrow-left" style="font-size: x-large"></i></a>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#id</th>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Birthday</th>
                                <th scope="col">Biography</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Place of Birth</th>
                                <th scope="col">Books</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data))
                                    <tr>
                                        <th scope="row">{{$data->id}}</th>
                                        <td>{{$data->first_name}}</td>
                                        <td>{{$data->last_name}}</td>
                                        <td>{{$data->birthday}}</td>
                                        <td>{{$data->biography}}</td>
                                        <td>{{$data->gender}}</td>
                                        <td>{{$data->place_of_birth}}</td>
                                        <td>
                                            @if(!empty($data->books))
                                                @foreach($data->books as $book)
                                                    <a href="{{route('view.book', ['id' => $book->id])}}">{{$book->title}}</a>,
                                                @endforeach
                                            @else
                                                <p>User Has no books, will you like to <a href="{{route('delete/single-author', ['id' => $data->id])}}">delete</a> ?</p>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
