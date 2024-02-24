<?php

namespace App\Http\Controllers;

use App\Models\Investigation;
use App\Models\Media;
use App\Models\User;
use App\Models\Website;
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
                return response()->json(['message'=>'Not admin'],400);
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
        //TODO
    }

    //Partie Website
    public function addWebsiteToInvestigation(Request $request, string $investigationID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'title' => 'required',
                'link' => 'required',
                'icon' => 'required',
            ]);
            $website = Website::create([
                'title' => $request->input('title'),
                'link' => $request->input('link'),
                'icon' => $request->input('icon'),
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
            $website = Website::create([
                'title' => $request->input('title'),
                'link' => $request->input('link'),
                'icon' => $request->input('icon'),
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
        //TODO
    }

    public function addMedia(Request $request){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $request->validate([
                'description' => 'required',
                'isTrustworthy' => 'required',
                'type' => 'required',
                'link' => 'required',
                'picture' => 'required'
            ]);

            $media = Media::create([
                'description' => $request->input('description'),
                'isTrustworthy' => $request->input('isTrustworthy'),
                'type' => $request->input('type'),
                'link' => $request->input('link'),
                'picture' => $request->input('picture')
            ]);
            return response()->json($media, 201);
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }

    public function linkMediaToInvestigation(string $mediaID, string $investigationID){
        //TODO
    }

    public function removeMediaFromInvestigation(string $investigationID, string $mediaID){
        //TODO
    }

    public function deleteMedia(string $mediaID){
        if ($this->checkAdminStatus()->getStatusCode() == 204) {
            $media = Media::find($mediaID);
            if ($media) {
                $media->delete();
                return response()->json($media, 201);
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
                return response()->json($user, 201);
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
                return response()->json($user, 201);
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
                return response()->json($user, 201);
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
                return response()->json($user, 201);
            } else {
                return response()->json(['message'=>'User not found'],404);
            }
        } else {
            return response()->json(['message'=>'User not admin, unauthorized'],401);
        }
    }
}
