<?php

namespace App\Http\Controllers;

use App\Models\MediaLocation;
use Illuminate\Http\Request;

class MediaLocationController extends Controller
{
    public function getAllMediaLocations(Request $request){
        return MediaLocation::all();
    }

    public function getMediaLocationsByInvestigationId(Request $request){
        $investigationID = $request->input('investigation_id');
        return MediaLocation::query()->where('investigation_id',$investigationID)->get();
    }

    //C'est pas la même les deux ?
    public function getMediaLocationsByInvestigation(Request $request){

    }
}
