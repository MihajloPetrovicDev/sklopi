<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Build;
use Illuminate\Http\Request;
use App\Services\ErrorService;
use Illuminate\Support\Facades\Auth;

class BuilderController extends Controller
{
    protected $errorService;

    
    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }


    public function getBuilderPage() {
        try {
            $builds = collect();

            if(Auth::check()) {
                $builds = Build::where('user_id', Auth::id())->get();
            }

            return view('builder', compact('builds'));
        }
        catch(Exception $e) {
            return $this->errorService->handleException($e);
        }
    }
}
