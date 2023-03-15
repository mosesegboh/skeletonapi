<?php

namespace App\Http\Controllers;

use App\Helper\ApiLogin;
use App\Jobs\AddAuthorJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = ApiLogin::instance()->makeCall('authors', 'GET', ApiLogin::instance()->getToken());

        return view('books.add')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'title' => 'required|max:250|regex:/^\s*[a-zA-Z0-9,.!\s]+\s*$/',
            'release_date' => 'required',
            'description' => 'required|max:250|regex:/^\s*[a-zA-Z0-9,.!\s]+\s*$/',
            'isbn' => 'required|max:250|regex:/^\s*[a-zA-Z0-9,.!\s]+\s*$/',
            'format' => 'required|max:250|regex:/^\s*[a-zA-Z0-9,.!\s]+\s*$/',
            'number_of_pages' => 'required|max:250|integer',
        ]);

        $body = $request->all();
        $body['author'] = [
            'id' => $request->get('author')
        ];

        $userId = Auth::id();

        $this->dispatch(new AddAuthorJob($body, $userId));

        return redirect()->to('add-book')->with('status', 'Book Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ApiLogin::instance()->makeCall('books'.'/'.$id, 'GET', ApiLogin::instance()->getToken());

        return view('books.single')->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ApiLogin::instance()->makeCall('books'.'/'.$id, 'DELETE', ApiLogin::instance()->getToken());

        return redirect()->to('home')->with('status', 'Book Deleted!');
    }
}
