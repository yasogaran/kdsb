<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Milestone;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $settings = Setting::getSettings();

        return view('about.index', compact('settings'));
    }

    public function history()
    {
        $milestones = Milestone::orderBy('year', 'desc')->get();

        return view('about.history', compact('milestones'));
    }

    public function team()
    {
        $settings = Setting::getSettings();

        return view('about.team', compact('settings'));
    }

    public function vision()
    {
        $settings = Setting::getSettings();

        return view('about.vision', compact('settings'));
    }
}
