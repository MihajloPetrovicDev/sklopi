<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestBuilderController extends Controller
{
    public function getGuestBuild() {
        return view('guest_build');
    }


    public function getAddGuestBuildComponentPage(Request $request) {
        $buildComponentTypeId = $request->query('component-type');

        return view('add_guest_build_component', compact('buildComponentTypeId'));
    }
}
