<?php

namespace App\Http\Controllers\Vue;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class VueHomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vue.index');
    }

    public function app()
    {
        return view('vue.app');
    }

}
