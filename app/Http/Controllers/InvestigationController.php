<?php

namespace App\Http\Controllers;

use App\Models\Completion;
use App\Models\Investigation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvestigationController extends Controller
{
    //AllInvestigation
    public function getAllInvestigations(){
        $investigations = Investigation::query()->select('*',DB::raw('0 as completion'))->get();
        if ($investigations->isEmpty())
            return response()->json(['message'=>'No investigations'],404);
        else
            return response()->json($investigations);
    }

    //InvestigationById
    public function getInvestigationById(string $investigationID){
        $investigation = Investigation::query()->select('*',DB::raw('0 as completion'))->find($investigationID);
        if ($investigation)
            return response()->json($investigation);
        else
            return response()->json(['message'=>'Investigation not found'],404);
    }

    //InvestigationByUserId
    public function getAllInvestigationsByUserId(string $userID){
        $investigations = Investigation::query()->join('completion', 'investigations.investigation_id','=','completion.investigation_id')
            ->where('completion.user_id',$userID)
            ->select('investigations.*','completion.completion')
            ->get();
        if ($investigations->isNotEmpty())
            return response()->json($investigations);
        else
            return response()->json(['message'=>'Investigations not found'],404);
    }

    function getInvestigationByIdAndUserId(string $userID,string $investigationID){
        $investigation = Investigation::query()->join('completion', 'investigations.investigation_id','=','completion.investigation_id')
            ->where('completion.user_id',$userID)
            ->select('investigations.*','completion.completion')
            ->find($investigationID);
        if ($investigation)
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
        if (!$completion) {
            return response()->json(['message' => 'Completion not found'], 404);
        }
        else {
            $completion = Completion::query()
                ->where('user_id', $userId)
                ->where('investigation_id', $invId)
                ->update([
                    'completion' => true
                ]);
            return response()->json(['message' => 'Completion updated to true']);
        }
    }
}
