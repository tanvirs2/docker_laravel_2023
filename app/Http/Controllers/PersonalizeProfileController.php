<?php

namespace App\Http\Controllers;

use App\Models\PersonalizeProfile;
use App\Http\Requests\StorePersonalizeProfileRequest;
use App\Http\Requests\UpdatePersonalizeProfileRequest;

class PersonalizeProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonalizeProfileRequest $request)
    {
        $user_id = $request->user_id;

        $personalizeProfile = new PersonalizeProfile();

        //find Personalize Profile data
        $hasPersonalizeProfile = $personalizeProfile->where('user_id', $user_id)->first();

        if ($hasPersonalizeProfile != null) {
            //update Personalize Profile data
            $hasPersonalizeProfile->status = $request->status;
            $hasPersonalizeProfile->save();
        } else {
            // Personalize Profile not found and new entry
            $personalizeProfile->user_id = $user_id;
            $personalizeProfile->status = $request->status;
            $personalizeProfile->save();

            $hasPersonalizeProfile = $personalizeProfile;
        }

        return $hasPersonalizeProfile;
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalizeProfile $personalizeProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalizeProfile $personalizeProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonalizeProfileRequest $request, PersonalizeProfile $personalizeProfile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalizeProfile $personalizeProfile)
    {
        //
    }
}
