<?php

namespace App\Http\Controllers;

use App\Models\MediaLocation;
use Illuminate\Http\Request;

class MediaLocationController extends Controller
{
    public function getAllMediaLocations(){
        return MediaLocation::all();
    }

    public function getMediaLocationsByInvestigationId(string $investigationID){
        return MediaLocation::query()->where('investigation_id',$investigationID)->get();
    }
}
