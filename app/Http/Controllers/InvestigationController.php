<?php

namespace App\Http\Controllers;

use App\Models\Completion;
use App\Models\Investigation;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    //AllInvestigation
    public function getAllInvestigation(Request $request){
        return Investigation::all();
    }

    //InvestigationById
    public function getInvestigationById(Request $request){
        $investigationID = $request->input('investigation_id');
        $investigation = Investigation::query()->find($investigationID);
        if ($investigation)
            return response()->json($investigation);
        else
            return response()->json(['message'=>'Investigation not found'],404);
    }

    //CompletionByUserID
    public function getCompletionByUserId(Request $request){
        $userID = $request->input('user_id');
        return Completion::query()->where('user_id', $userID)->get();
    }

    //CompletionByInvestigationID+UserId
    public function getCompletionByUserIdAndInvId(Request $request){
        $userID = $request->input('user_id');
        $InvID = $request->input('investigation_id');
        return Completion::query()->where('user_id', $userID)
            ->where('investigation_id','=',$InvID);
    }
}
