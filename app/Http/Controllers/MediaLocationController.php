<?php

namespace App\Http\Controllers;

use App\Models\MediaLocation;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MediaLocationController extends Controller
{
    public function getAllMediaLocations(){
        $mediaLocation = MediaLocation::all();
        if ($mediaLocation->isNotEmpty())
            return response()->json($mediaLocation);
        else
            return response()->json(['message'=>'No mediaLocations'],404);
    }

    public function getMediaLocationsByInvestigationId(string $investigationID){
        $mediaLocation = MediaLocation::query()
            ->where('investigation_id',$investigationID)
            ->get();
        if ($mediaLocation->isNotEmpty())
            return response()->json($mediaLocation);
        else
            return response()->json(['message'=>'MediaLocation not found'],404);
    }

    public function getMediaLocationsByInvestigationIdAndUserId(string $userID, string $investigationID){
        $mediaLocations = MediaLocation::query()
            ->leftJoin('user_media_location', function (JoinClause $join) use ($userID) {
                $join->on('media_locations.id','=','user_media_location.media_location_id');
                $join->where('user_media_location.user_id',$userID);
            })
            ->leftJoin('media','media.media_id','=','user_media_id')
            ->where('investigation_id',$investigationID)
            ->select('id','expected_media_id','media_locations.description as location_description','x','y','media.*')
            ->get();
        if ($mediaLocations)
            return response()->json($mediaLocations);
        else
            return response()->json(['message'=>'MediaLocation not found'],404);
    }

    public function getMediaLocationById(string $mediaLocationID){
        $mediaLocation = MediaLocation::find($mediaLocationID);
        if ($mediaLocation)
            return response()->json($mediaLocation);
        else
            return response()->json(['message'=>'MediaLocation not found'],404);
    }
}
