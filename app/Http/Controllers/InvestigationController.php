<?php

namespace App\Http\Controllers;

use App\Models\Completion;
use App\Models\Investigation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function getAllInvestigationsForUser(){
        if (Auth::check()) {
            $userID = Auth::user()->getId();
            $investigations = Investigation::query()->join('completion', 'investigations.investigation_id', '=', 'completion.investigation_id')
                ->where('completion.user_id', $userID)
                ->select('investigations.*', 'completion.completion')
                ->get();
            if ($investigations->isNotEmpty())
                return response()->json($investigations);
            else
                return response()->json(['message' => 'Investigations not found'], 404);
        }
        else
            return response()->json(['message' => 'User is not authentified'], 401);
    }

    function getInvestigationByIdForUser(string $userID,string $investigationID){
        if (Auth::check()) {
            $userID = Auth::user()->getId();
            $investigation = Investigation::query()->join('completion', 'investigations.investigation_id', '=', 'completion.investigation_id')
                ->where('completion.user_id', $userID)
                ->select('investigations.*', 'completion.completion')
                ->find($investigationID);
            if ($investigation)
                return response()->json($investigation);
            else
                return response()->json(['message' => 'Investigation not found'], 404);
        }
        else
            return response()->json(['message' => 'User is not authentified'], 401);
    }

    public function updateCompletionOfUser(string $investigationID)
    {
        if (Auth::check()) {
            $userID = Auth::user()->getId();
            Completion::query()->updateOrInsert([
                'user_id' => $userID,
                'investigation_id' => $investigationID
            ],[
                'user_id' => $userID,
                'investigation_id' => $investigationID,
                'completion' => true
            ]);
            return response()->json(['message' => 'Completion updated']);
        }
        else
            return response()->json(['message' => 'User is not authentified'], 401);
    }
}
