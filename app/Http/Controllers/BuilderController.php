<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Build;
use Illuminate\Http\Request;
use App\Helpers\EncodeHelper;
use App\Models\DeliveryGroup;
use App\Models\BuildComponent;
use App\Services\ErrorService;
use Illuminate\Support\Facades\Auth;

class BuilderController extends Controller
{
    protected $errorService;

    
    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }


    public function getMyBuildsPage() {
        try {
            $builds = collect();

            if(Auth::check()) {
                $builds = Build::where('user_id', Auth::id())->get();
            }

            return view('my_builds', compact('builds'));
        }
        catch(Exception $e) {
            return $this->errorService->handleException($e);
        }
    }


    public function getCreateNewBuildPage() {
        return view('create_new_build');
    }


    public function createNewBuild(Request $request) {
        $incomingFields = $request->validate([
            'buildName' => ['max: 30'],
            'buildVisibility' => ['required', 'boolean'],
        ],
        [
            'buildName.max' => __('errors.create_new_build.build_name_max'),
            'buildVisibility.required' => __('errors.create_new_build.build_visibility_reqired'),
            'buildVisibility.boolean' => __('errors.create_new_build.build_visibility_boolean'),
        ]);

        try {
            if(!$incomingFields['buildName']) {
                $buildName = __('ui.create_new_build.build');
            }
            else {
                $buildName = $incomingFields['buildName'];
            }

            $build = new Build();

            $build->user_id = Auth::id();
            $build->name = $buildName;
            $build->is_public = $incomingFields['buildVisibility'];
            $build->country_id = 1;
            $build->currency = 'RSD';

            $build->save();

            return response()->json([], 200);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function getBuild($hashedId) {
        try {
            $id = EncodeHelper::decode($hashedId);

            $build = Build::findOrFail($id);

            $buildComponents = BuildComponent::where('build_id', $build->id)->get();

            return view('build', compact('build', 'buildComponents'));
        }
        catch(Exception $e) {
            $this->errorService->handleException($e);
        }
    }


    public function getGuestBuild() {
        return view('guest_build');
    }


    public function getAddBuildComponent(Request $request) {
        try {
            $encodedBuildId = $request->query('build-id');
            $buildId = EncodeHelper::decode($encodedBuildId);
            $buildComponentTypeId = $request->query('build-component-type-id');

            $build = Build::findOrFail($buildId);

            return view('add_build_component', compact('build', 'buildComponentTypeId', 'encodedBuildId'));
        }
        catch(Exception $e) {
            $this->errorService->handleException($e);
        }
    }


    public function getBuildDeliveryGroups(Request $request) {
        $incomingFields = $request->validate([
            'buildId' => ['required', 'int']
        ]);

        try {
            $deliveryGroups = DeliveryGroup::where('user_id', Auth::id())
                ->where(function ($query) use ($incomingFields) {
                    $query->where('build_id', null)
                        ->orWhere('build_id', $incomingFields['buildId']);
                })
                ->get()
                ->toArray();
            
            return response()->json(['deliveryGroups' => $deliveryGroups], 200);
        }
        catch(Exception $e) {
            $this->errorService->handleExceptionJSON($e);
        }
    }
}
