<?php

namespace App\Http\Controllers;

use App\Helper\ApiLogin;

class AuthorController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ApiLogin::instance()->makeCall('authors'.'/'.$id, 'GET', ApiLogin::instance()->getToken());

        return view('authors.single')->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ApiLogin::instance()->makeCall('authors'.'/'.$id, 'DELETE', ApiLogin::instance()->getToken());

        return redirect()->to('home')->with('status', 'Author Deleted!');

    }
}
