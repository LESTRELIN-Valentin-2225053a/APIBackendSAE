<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    //MediaByInvID
    public function getMediaByInvId(string $investigationID){
        return Media::query()->join('media_used_by_investigation', 'media.media_id','=','media_used_by_investigation.media_id')
            ->where('media_used_by_investigation.investigation_id', $investigationID)
            ->select('media.*','media_used_by_investigation.defaultPosX as PosX','media_used_by_investigation.defaultPosY as PosY')
            ->get();
    }
}
