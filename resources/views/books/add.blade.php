@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}
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
                            <form action="{{route('save-book')}}" method="POST">
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label">Author</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" aria-label="Default select example" name="author">
                                            <option selected>Select Author</option>
                                            @if(!empty($data))
                                                @foreach ($data->items as $data)
                                                    <option value="{{$data->id}}">{{$data->first_name . ' ' . $data->last_name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="title" class="col-sm-2 col-form-label">Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ old('title') }}">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="release_date" class="col-sm-2 col-form-label">Release Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="release_date" id="release_date" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="release_date" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="release_date" class="col-sm-2 col-form-label">isbn</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="isbn" id="release_date" placeholder="Isbn">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="release_date" class="col-sm-2 col-form-label">Format</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="format" id="format" placeholder="Format">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="release_date" class="col-sm-2 col-form-label">Number of Pages</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" name="number_of_pages" id="number_of_pages" placeholder="Number of Pages">
                                    </div>
                                </div>
                                @csrf
                                <div class="form-group row mt-3">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Save Book</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
