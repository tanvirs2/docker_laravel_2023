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
        $selectedSourceArr = [];
        $selectedAuthorArr = [];

        $personalizeProfile = new PersonalizeProfile();

        //find Personalize Profile data
        $hasPersonalizeProfile = $personalizeProfile->where('user_id', $user_id)->first();

        if ($hasPersonalizeProfile != null) {
            //update Personalize Profile data

            /*sources*/
            $selectedSourceArr = json_decode($hasPersonalizeProfile->sources);
            if ($request->selectedSource) {
                $selectedSourceArr[] = $request->selectedSource;
            }
            $hasPersonalizeProfile->sources = json_encode($selectedSourceArr);

            /*authors*/
            $selectedAuthorArr = json_decode($hasPersonalizeProfile->authors);
            if ($request->selectedAuthor) {
                $selectedAuthorArr[] = $request->selectedAuthor;
            }
            $hasPersonalizeProfile->authors = json_encode($selectedAuthorArr);

            $hasPersonalizeProfile->status = $request->status;
            $hasPersonalizeProfile->save();
        } else {
            // Personalize Profile not found and new entry
            $personalizeProfile->user_id = $user_id;
            if ($request->selectedSource) {
                $selectedSourceArr[] = $request->selectedSource;
            }
            $personalizeProfile->sources = json_encode($selectedSourceArr);

            /*authors*/
            if ($request->selectedAuthor) {
                $selectedAuthorArr[] = $request->selectedAuthor;
            }
            $personalizeProfile->authors = json_encode($selectedAuthorArr);

            $personalizeProfile->status = $request->status;
            $personalizeProfile->save();

            $hasPersonalizeProfile = $personalizeProfile;
        }

        return [
            $hasPersonalizeProfile,
            json_decode($hasPersonalizeProfile->sources),
            json_decode($hasPersonalizeProfile->authors)
        ];
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
