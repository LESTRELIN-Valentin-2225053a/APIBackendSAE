<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Media;
use App\Models\MediaUsedByInvestigation;
use App\Models\User;
use App\Models\Website;
use App\Sevices\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function checkAdminStatus() {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isAdmin()) {
                return response()->json(['message'=>'Is admin'],204);
            } else {
                return response()->json(['message'=>'Not admin'],401);
            }
        } else {
            return response()->json(['message'=>'User not found'],404);
        }
    }

    //Partie Investigation
    public function addNewInvestigation(Request $request){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'explication' => 'required',
                'board_type' => 'required',
            ]);
            $investigation = Investigation::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'board_type' => $request->input('board_type'),
                'explication' => $request->input('explication'),
            ]);
            return response()->json($investigation, 201);
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function updateInvestigation(Request $request, string $investigationID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'title' => 'required',
                'description' => 'required',
                'explication' => 'required',
                'board_type' => 'required',
            ]);
            $investigation = Investigation::find($investigationID);
            if ($investigation) {
                $investigation->update([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'board_type' => $request->input('board_type'),
                    'explication' => $request->input('explication'),
                ]);
                return response()->json($investigation, 201);
            } else {
                return response()->json(['message'=>'Investigation not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function deleteInvestigation(string $investigationID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $investigation = Investigation::find($investigationID);
            if ($investigation) {
                $investigation->delete();
                return response()->json($investigation, 201);
            } else {
                return response()->json(['message'=>'Investigation not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    //Partie Website
    public function addWebsiteToInvestigation(Request $request, string $investigationID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'title' => 'required',
                'link' => 'required',
                'icon' => 'required',
            ]);
            $icon = MediaUploader::uploadMedia($request->file('icon')->getRealPath(), 'image');
            $website = Website::create([
                'title' => $request->input('title'),
                'link' => $request->input('link'),
                'icon' => $icon
            ]);
            $investigation = Investigation::find($investigationID);
            if ($investigation) {
                $investigation->websites()->attach($website->id);
                return response()->json($website, 201);
            } else {
                return response()->json(['message'=>'Investigation not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function addWebsite(Request $request){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'title' => 'required',
                'link' => 'required',
                'icon' => 'required',
            ]);
            $icon = MediaUploader::uploadMedia($request->file('icon')->getRealPath(), 'image');
            $website = Website::create([
                'title' => $request->input('title'),
                'link' => $request->input('link'),
                'icon' => $icon
            ]);
            return response()->json($website, 201);
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function linkWebsiteToInvestigation(string $websiteID, string $investigationID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $website = Website::find($websiteID);
            $investigation = Investigation::find($investigationID);
            if ($website && $investigation) {
                $investigation->websites()->attach($website->id);
                return response()->json($website, 201);
            } else {
                return response()->json(['message'=>'Website or investigation not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function updateWebsite(Request $request, string $websiteID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'title' => 'required',
                'link' => 'required',
                'icon' => 'required',
            ]);
            $website = Website::find($websiteID);
            if ($website) {
                $icon = MediaUploader::uploadMedia($request->file('icon')->getRealPath(), 'image');
                $website->update([
                    'title' => $request->input('title'),
                    'link' => $request->input('link'),
                    'icon' => $icon
                ]);
                return response()->json($website, 201);
            } else {
                return response()->json(['message'=>'Website not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function removeWebsiteFromInvestigation(string $investigationID, string $websiteID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $website = Website::find($websiteID);
            $investigation = Investigation::find($investigationID);
            if ($website && $investigation) {
                $investigation->websites()->detach($website->id);
                return response()->json($website, 201);
            } else {
                return response()->json(['message'=>'Website or investigation not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function deleteWebsite(string $websiteID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $website = Website::find($websiteID);
            if ($website) {
                $website->delete();
                return response()->json($website, 201);
            } else {
                return response()->json(['message'=>'Website not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    //Partie Media
    public function addMediaToInvestigation(Request $request, string $investigationID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'description' => 'required',
                'isTrustworthy' => 'required',
                'type' => 'required',
                'picture' => 'required',
                'link' => 'required'
            ]);
            $picture = MediaUploader::uploadMedia($request->file('picture')->getRealPath(), 'image');
            if($request->input('type') == 'img'){
                $media = MediaUploader::uploadMedia($request->file('link')->getRealPath(), 'image');
            }
            elseif ($request->input('type') == 'video'){
                $media = MediaUploader::uploadMedia($request->file('link'), 'video');
            }
            else {
                return response()->json(['message'=>'Type not supported'],400);
            }
            if(isset($media) && isset($picture)){
                $newMedia = Media::create([
                    'description' => $request->input('description'),
                    'isTrustworthy' => $request->input('isTrustworthy'),
                    'type' => $request->input('type'),
                    'link' => $media,
                    'picture' => $picture
                ]);
                $investigation = Investigation::find($investigationID);
                if ($investigation) {
                    $investigation->media_used_by_investigations()->create([
                        'media_id' => $newMedia->media_id,
                        'defaultPosX' => 0,
                        'defaultPosY' => 0
                    ]);
                    return response()->json($newMedia, 201);
                } else {
                    return response()->json(['message'=>'Investigation not found'],404);
                }
            } else {
                return response()->json(['message'=>'Error while uploading media'],400);
            }
        }
        else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function addMedia(Request $request){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'description' => 'required',
                'isTrustworthy' => 'required',
                'type' => 'required',
                'picture' => 'required',
                'link' => 'required'
            ]);
            $picture = MediaUploader::uploadMedia($request->file('picture')->getRealPath(), 'image');
            if($request->input('type') == 'img'){
                $media = MediaUploader::uploadMedia($request->file('link')->getRealPath(), 'image');
            }
            elseif ($request->input('type') == 'video'){
                $media = MediaUploader::uploadMedia($request->file('link'), 'video');
            }
            else {
                return response()->json(['message'=>'Type not supported'],400);
            }
            if(isset($media) && isset($picture)){
                $newMedia = Media::create([
                    'description' => $request->input('description'),
                    'isTrustworthy' => $request->input('isTrustworthy'),
                    'type' => $request->input('type'),
                    'link' => $media,
                    'picture' => $picture
                ]);
                return response()->json($newMedia, 201);
            } else {
                return response()->json(['message'=>'Error while uploading media'],400);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function linkMediaToInvestigation(string $mediaID, string $investigationID, Request $request){
        if($this->checkAdminStatus()->getStatusCode() == 204){
            $media = Media::find($mediaID);
            $investigation = Investigation::find($investigationID);
            $request->validate([
                'PosX' => 'required',
                'PosY' => 'required'
            ]);
            if ($media && $investigation) {
                $investigation->media_used_by_investigations()->create([
                    'media_id' => $media->media_id,
                    'defaultPosX' => $request->input('PosX'),
                    'defaultPosY' => $request->input('PosY')
                ]);
                return response()->json(['message'=>'Success'], 201);
            } else {
                return response()->json(['message'=>'Media or investigation not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function removeMediaFromInvestigation(string $investigationID, string $mediaID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $media = Media::find($mediaID);
            $investigation = Investigation::find($investigationID);
            if ($media && $investigation) {
                $investigation->media_used_by_investigations()->where('media_id', $mediaID)->delete();
                return response()->json(['message'=>'Success'], 201);
            }
            else {
                return response()->json(['message'=>'Media not found in investigation'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function updateMedia(Request $request, string $mediaID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'description' => 'required',
                'isTrustworthy' => 'required',
                'type' => 'required',
                'picture' => 'required',
                'link' => 'required'
            ]);
            $media = Media::find($mediaID);
            if ($media) {
                $picture = MediaUploader::uploadMedia($request->file('picture')->getRealPath(), 'image');
                if($request->input('type') == 'img'){
                    $mediaLink = MediaUploader::uploadMedia($request->file('link')->getRealPath(), 'image');
                }
                elseif ($request->input('type') == 'video'){
                    $mediaLink = MediaUploader::uploadMedia($request->file('link'), 'video');
                }
                else {
                    return response()->json(['message'=>'Type not supported'],400);
                }
                $media->update([
                    'description' => $request->input('description'),
                    'isTrustworthy' => $request->input('isTrustworthy'),
                    'type' => $request->input('type'),
                    'link' => $mediaLink,
                    'picture' => $picture
                ]);
                return response()->json($media, 201);
            } else {
                return response()->json(['message'=>'Media not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function deleteMedia(string $mediaID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $media = Media::find($mediaID);
            if ($media) {
                $media->delete();
                return response()->json($media, 200);
            } else {
                return response()->json(['message'=>'Media not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }


    //Partie User
    public function blockUser(string $userID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $user = User::find($userID);
            if ($user) {
                $user->block();
                return response()->json($user, 200);
            } else {
                return response()->json(['message'=>'User not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function unblockUser(string $userID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $user = User::find($userID);
            if ($user) {
                $user->unblock();
                return response()->json($user, 200);
            } else {
                return response()->json(['message'=>'User not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function deleteUser(string $userID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $user = User::find($userID);
            if ($user) {
                $user->delete();
                return response()->json($user, 200);
            } else {
                return response()->json(['message'=>'User not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function promoteUser(string $userID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $user = User::find($userID);
            if ($user) {
                $user->promote();
                return response()->json($user, 200);
            } else {
                return response()->json(['message'=>'User not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }
}
