<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\UserMediaPosition;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    //MediaByInvID
    public function getMediaByInvId(string $investigationID){
        $media =  Media::query()->join('media_used_by_investigation', 'media.media_id','=','media_used_by_investigation.media_id')
            ->where('media_used_by_investigation.investigation_id', $investigationID)
            ->select('media.*','media_used_by_investigation.defaultPosX as PosX','media_used_by_investigation.defaultPosY as PosY')
            ->get();
        if ($media->isNotEmpty())
            return response()->json($media);
        else
            return response()->json(['message'=>'Media not found'],404);
    }

    public function getMediasByInvAndUserId(string $investigationID, string $userID){
        $mediaIdsSavedByUser = UserMediaPosition::query()
            ->where('investigation_id',$investigationID)
            ->where('user_id',$userID)
            ->select('media_id');
        $mediasUsedByInvestigation = Media::query()->join('media_used_by_investigation', 'media.media_id','=','media_used_by_investigation.media_id')
            ->where('media_used_by_investigation.investigation_id', $investigationID)
            ->select('media.*','media_used_by_investigation.defaultPosX as PosX','media_used_by_investigation.defaultPosY as PosY')
            ->whereNotIn('media.media_id',$mediaIdsSavedByUser);
        $medias = Media::query()->join('user_media_position', 'media.media_id','=','user_media_position.media_id')
            ->where('user_media_position.investigation_id',$investigationID)
            ->where('user_media_position.user_id',$userID)
            ->select('media.*','user_media_position.PosX','user_media_position.PosY')
            ->union($mediasUsedByInvestigation)
            ->get();
        if ($medias)
            return response()->json($medias);
        else
            return response()->json(['message'=>'Media not found'],404);
    }

    public function updateMediaPositionOfUser(Request $request){
        $userID = $request->input('user_id');
        $invID = $request->input('investigation_id');
        $mediaID = $request->input('media_id');
        $PosX = $request->input('PosX');
        $PosY = $request->input('PosY');
        $possibleMediaPos = UserMediaPosition::query()->where('user_id', $userID)
            ->where('investigation_id', $invID)
            ->where('media_id', $mediaID)->first()->get();
        if ($possibleMediaPos->isNotEmpty()){
            UserMediaPosition::query()->where('user_id', $userID)
                ->where('investigation_id', $invID)
                ->where('media_id', $mediaID)->first()
                ->update([
                    'PosX'=> $PosX,
                    'PosY'=> $PosY
                ]);
        }
        else {
            $newMediaPosUser = new UserMediaPosition();
            $newMediaPosUser->user_id = $userID;
            $newMediaPosUser->investigation_id = $invID;
            $newMediaPosUser->media_id = $mediaID;
            $newMediaPosUser->posX = $PosX;
            $newMediaPosUser->posY = $PosY;
            $newMediaPosUser->save();
        }
        return response()->json(['message'=>'Media position saved in user_media_position']);
    }
}
