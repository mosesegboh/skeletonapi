@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }} &nbsp; &nbsp; &nbsp;Welcome {{ Auth::user()->name }} {{ Auth::user()->last_name }} !!!! &nbsp;&nbsp; &nbsp;
                    <a href="{{route('add-book')}}" title="Add book">
                        <i class="bi bi-plus" style="font-size: x-large; font-weight: bold"></i>
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
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Birthday</th>
                            <th scope="col">Gender</th>
                            <th scope="col">Place Of Birth</th>
                            <th scope="col">View</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                                @foreach ($data->items as $data)
                                    <tr>
                                        <th scope="row">{{$data->id}}</th>
                                        <td>{{$data->first_name}}</td>
                                        <td>{{$data->last_name}}</td>
                                        <td>{{substr($data->birthday,10)}}</td>
                                        <td>{{$data->gender}}</td>
                                        <td>{{$data->place_of_birth}}</td>
                                        <td><a href="{{route('view.author', ['id' => $data->id])}}"><i class="bi bi-eye"></i></a></td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
