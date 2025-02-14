<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;

class MapController extends Controller
{
    //
    public function map($id)
    {
        // Find the resort where user_id matches the provided $id
        $selectedResort = UserInfo::where('user_id', $id)->firstOrFail();

        // Pass latitude and longitude to the view
        return view('map', [
            'selectedResort' => $selectedResort,
            'latitude' => $selectedResort->latitude,
            'longitude' => $selectedResort->longitude
        ]);
    }
}
