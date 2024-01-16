<?php

namespace App\Http\Controllers;

use App\Models\MediaLocation;
use Illuminate\Http\Request;

class MediaLocationController extends Controller
{
    public function getAllMediaLocations(){
        $mediaLocation = MediaLocation::all();
        if ($mediaLocation)
            return response()->json($mediaLocation);
        else
            return response()->json(['message'=>'No mediaLocations'],404);
    }

    public function getMediaLocationsByInvestigationId(string $investigationID){
        $mediaLocation = MediaLocation::query()->where('investigation_id',$investigationID)->get();
        if ($mediaLocation)
            return response()->json($mediaLocation);
        else
            return response()->json(['message'=>'MediaLocation not found'],404);
    }
}
