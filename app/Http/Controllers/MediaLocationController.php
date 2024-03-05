<?php

namespace App\Http\Controllers;

use App\Models\MediaLocation;
use App\Models\UserMediaLocation;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function getMediaLocationsByInvestigationIdForUser(string $investigationID){
        if (Auth::check()) {
            $userID = Auth::user()->getId();
            $mediaLocations = MediaLocation::query()
                ->leftJoin('user_media_location', function (JoinClause $join) use ($userID) {
                    $join->on('media_locations.id', '=', 'user_media_location.media_location_id');
                    $join->where('user_media_location.user_id', $userID);
                })
                ->leftJoin('media', 'media.media_id', '=', 'user_media_id')
                ->where('investigation_id', $investigationID)
                ->select('id', 'expected_media_id', 'media_locations.description', 'x', 'y',
                'media.media_id','media.description as media_description','media.isTrustworthy as media_isTrustworthy','media.type as media_type',
                'media.link as media_link','media.picture as media_picture')
                ->get();
            if ($mediaLocations)
                return response()->json($mediaLocations);
            else
                return response()->json(['message' => 'MediaLocation not found'], 404);
        }
        else
            return response()->json(['message' => 'User is not authentified'], 401);
    }

    public function updateMediaLocationsForUser(Request $request){
        if (Auth::check()) {
            $userID = Auth::user()->getId();
            foreach ($request->all() as $mediaLocation){
                $mediaLocationID = $mediaLocation['id'];
                $mediaID = $mediaLocation['media_id'] ?? null;
                UserMediaLocation::query()->updateOrInsert([
                    'user_id' => $userID,
                    'media_location_id' => $mediaLocationID
                ],[
                    'user_id' => $userID,
                    'media_location_id' => $mediaLocationID,
                    'user_media_id' => $mediaID
                ]);
            }
            return response()->json($request);
        }
        else
            return response()->json(['message' => 'User is not authentified'], 401);
    }

    public function getMediaLocationById(string $mediaLocationID){
        $mediaLocation = MediaLocation::find($mediaLocationID);
        if ($mediaLocation)
            return response()->json($mediaLocation);
        else
            return response()->json(['message'=>'MediaLocation not found'],404);
    }
}
