<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    //WebsiteByInvId
    public function getWebsiteByInvId(string $investigationID){
        $website = Website::query()->join('websites_used_by_investigation', 'websites.id','=','websites_used_by_investigation.website_id')
            ->where('websites_used_by_investigation.investigation_id', $investigationID)
            ->select('websites.*')->get();
        if ($website)
            return response()->json($website);
        else
            return response()->json(['message'=>'Media not found'],404);
    }
}
