<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuideSteps;

class HelpController extends Controller
{
    public function index()
    {
        $guideSteps = GuideSteps::orderBy('step_number')->get();
        
        return view('pages.help', compact('guideSteps'));
    }
}