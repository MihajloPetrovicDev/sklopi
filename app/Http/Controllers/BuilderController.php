<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuilderController extends Controller
{
    public function getBuilderPage() {
        return view('builder');
    }
}
