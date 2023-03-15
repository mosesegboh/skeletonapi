@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between; align-items: center; align-content: center">
                        List Of Books
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{route('add-book', ['id' => $data->id])}}" title="Add book">
                            <i class="bi bi-plus" style="font-size: x-large; font-weight: bold"></i>
                        </a>

                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="{{route('home')}}" title="Go back">
                            <i class="bi bi-arrow-left" style="font-size: x-large; font-weight: bolder"></i>
                        </a>
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
                                <th scope="col">Author</th>
                                <th scope="col">Title</th>
                                <th scope="col">Release Date</th>
                                <th scope="col">Description</th>
                                <th scope="col">isbn</th>
                                <th scope="col">format</th>
                                <th scope="col">number of pages</th>
                                <th scope="col">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($data))
                                    <tr>
                                        <th scope="row">{{$data->id}}</th>
                                        <td>{{$data->author->id}}</td>
                                        <th scope="row">{{$data->title}}</th>
                                        <td>{{$data->release_date ? substr($data->release_date,0,10) : ''}}</td>
                                        <td>{{$data->description}}</td>
                                        <td>{{$data->isbn}}</td>
                                        <td>{{$data->format}}</td>
                                        <td>{{$data->number_of_pages}}</td>
                                        <td><a href="{{route('delete/single-book', ['id' => $data->id])}}"><i class="bi bi-trash"></i></a></td>
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
