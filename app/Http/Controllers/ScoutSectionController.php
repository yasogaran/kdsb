<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScoutSectionController extends Controller
{
    private $sections = [
        'singithi' => [
            'name' => 'Singithi',
            'age_range' => 'Ages 3-5',
            'description' => 'The Singithi section is designed for our youngest scouts, introducing them to the world of scouting through play and fun activities.',
            'color' => 'pink',
        ],
        'cubs' => [
            'name' => 'Cubs',
            'age_range' => 'Ages 6-10',
            'description' => 'Cubs learn basic scouting skills through games, outdoor activities, and teamwork.',
            'color' => 'yellow',
        ],
        'scouts' => [
            'name' => 'Scouts',
            'age_range' => 'Ages 11-15',
            'description' => 'Scouts develop leadership skills, outdoor competencies, and community service values.',
            'color' => 'green',
        ],
        'senior-scouts' => [
            'name' => 'Senior Scouts',
            'age_range' => 'Ages 16-18',
            'description' => 'Senior Scouts take on greater challenges and leadership responsibilities.',
            'color' => 'red',
        ],
        'rovers' => [
            'name' => 'Rovers',
            'age_range' => 'Ages 18-25',
            'description' => 'Rovers focus on service, leadership development, and preparing for adult responsibilities.',
            'color' => 'maroon',
        ],
        'masters' => [
            'name' => 'Scout Masters',
            'age_range' => 'Adult Leaders',
            'description' => 'Adult volunteers who guide and mentor young scouts in their scouting journey.',
            'color' => 'navy',
        ],
    ];

    public function index()
    {
        return view('sections.index', ['sections' => $this->sections]);
    }

    public function show($section)
    {
        if (!isset($this->sections[$section])) {
            abort(404);
        }

        $sectionData = $this->sections[$section];

        return view('sections.show', compact('section', 'sectionData'));
    }
}
