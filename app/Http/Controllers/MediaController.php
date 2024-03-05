<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\UserMediaPosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    //MediaByInvID
    public function getMediaByInvId(string $investigationID){
        $media =  Media::query()->join('media_used_by_investigation', 'media.media_id','=','media_used_by_investigation.media_id')
            ->where('media_used_by_investigation.investigation_id', $investigationID)
            ->select(
                'media.media_id',
                'media.description',
                'media.isTrustworthy',
                'media.type',
                'media.link',
                'media.picture',
                'media_used_by_investigation.defaultPosX as posX',
                'media_used_by_investigation.defaultPosY as posY')
            ->get();
        if ($media->isNotEmpty())
            return response()->json($media);
        else
            return response()->json(['message'=>'Media not found'],404);
    }

    public function getMediasByInvForUser(string $investigationID){
        if (Auth::check()) {
            $userID = Auth::user()->getId();
            $mediaIdsSavedByUser = UserMediaPosition::query()
                ->where('investigation_id', $investigationID)
                ->where('user_id', $userID)
                ->select('media_id');
            $mediasUsedByInvestigation = Media::query()->join('media_used_by_investigation', 'media.media_id', '=', 'media_used_by_investigation.media_id')
                ->where('media_used_by_investigation.investigation_id', $investigationID)
                ->select('media.*', 'media_used_by_investigation.defaultPosX as posX', 'media_used_by_investigation.defaultPosY as posY',DB::raw('NULL as userTrustWorthy'))
                ->whereNotIn('media.media_id', $mediaIdsSavedByUser);
            $medias = Media::query()->join('user_media_position', 'media.media_id', '=', 'user_media_position.media_id')
                ->where('user_media_position.investigation_id', $investigationID)
                ->where('user_media_position.user_id', $userID)
                ->select('media.media_id','media.description','media.isTrustworthy','media.type','media.link','media.picture', 'user_media_position.posX', 'user_media_position.posY','user_media_position.userTrustWorthy')
                ->union($mediasUsedByInvestigation)
                ->get();
            if ($medias)
                return response()->json($medias);
            else
                return response()->json(['message' => 'Medias not found'], 404);
        }
        else
            return response()->json(['message' => 'User is not authentified'], 401);
    }

    public function updateMediasForUser(string $investigationID, Request $request){
        if (Auth::check()) {
            $userID = Auth::user()->getId();
            foreach ($request->all() as $media){
                $mediaID = $media['media_id'];
                $posX = $media['posX'];
                $posY = $media['posY'];
                $userTrustWorthy = $media['userTrustWorthy'];
                UserMediaPosition::query()->updateOrInsert([
                    'user_id' => $userID,
                    'investigation_id' => $investigationID,
                    'media_id' => $mediaID,
                ],[
                    'user_id' => $userID,
                    'investigation_id' => $investigationID,
                    'media_id' => $mediaID,
                    'posX' => $posX,
                    'posY' => $posY,
                    'userTrustWorthy' => $userTrustWorthy
                ]);
            }
            return response()->json($request,200);
        }
        else
            return response()->json(['message' => 'User is not authentified'], 401);
    }

    public function getAllMedias(){
        $medias = Media::all();
        if ($medias->isNotEmpty())
            return response()->json($medias);
        else
            return response()->json(['message'=>'Medias not found'],404);
    }

    public function getMediaById(string $mediaID){
        $media = Media::find($mediaID);
        if ($media)
            return response()->json($media);
        else
            return response()->json(['message'=>'Media not found'],404);
    }
}
