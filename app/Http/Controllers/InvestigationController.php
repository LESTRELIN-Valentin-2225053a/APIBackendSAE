<?php

namespace App\Http\Controllers;

use App\Models\Completion;
use App\Models\Investigation;
use Illuminate\Http\Request;

class InvestigationController extends Controller
{
    //AllInvestigation
    public function getAllInvestigation(){
        $investigation = Investigation::all();
        if ($investigation->isEmpty())
            return response()->json(['message'=>'No investigations'],404);
        else
            return response()->json($investigation);
    }

    //InvestigationById
    public function getInvestigationById(string $investigationID){
        $investigation = Investigation::query()->find($investigationID);
        if ($investigation->isNotEmpty())
            return response()->json($investigation);
        else
            return response()->json(['message'=>'Investigation not found'],404);
    }

    //CompletionByUserID
    public function getCompletionByUserId(string $userId){
        $completion = Completion::query()->where('user_id', $userId)->get();
        if ($completion->isNotEmpty())
            return response()->json($completion);
        else
            return response()->json(['message'=>'Completion not found'],404);
    }

    //CompletionByInvestigationID+UserId
    public function getCompletionByUserIdAndInvId(string $userID, string $InvID){
        $completion = Completion::query()->where('user_id', $userID)
            ->where('investigation_id',$InvID)->get();
        if ($completion->isNotEmpty())
            return response()->json($completion);
        else
            return response()->json(['message'=>'Completion not found'],404);
    }

    public function updateCompletionOfUser(Request $request)
    {
        $userId = $request->input('user_id');
        $invId = $request->input('investigation_id');
        $completion = Completion::query()
            ->where('user_id', $userId)
            ->where('investigation_id', $invId)
            ->first();
        //if (!$completion) {
        //    return response()->json(['message' => 'Completion not found'], 404);
        //} else {
        //    $completion->update([
        //        'completion' => true
        //    ]);
            return response()->json($completion);
        //}
    }
}
