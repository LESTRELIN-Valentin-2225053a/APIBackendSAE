<?php

namespace App\Http\Controllers;

use App\Models\Completion;
use App\Models\Investigation;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    //AllInvestigation
    public function getAllInvestigation(){
        return Investigation::all();
    }

    //InvestigationById
    public function getInvestigationById(string $investigationID){
        $investigation = Investigation::query()->find($investigationID);
        if ($investigation)
            return response()->json($investigation);
        else
            return response()->json(['message'=>'Investigation not found'],404);
    }

    //CompletionByUserID
    public function getCompletionByUserId(string $userId){
        return Completion::query()->where('user_id', $userId)->get();
    }

    //CompletionByInvestigationID+UserId
    public function getCompletionByUserIdAndInvId(string $userID, string $InvID){
        return Completion::query()->where('user_id', $userID)
            ->where('investigation_id','=',$InvID);
    }
}
