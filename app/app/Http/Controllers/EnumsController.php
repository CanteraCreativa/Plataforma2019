<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\StudyLevel;
use Illuminate\Http\Request;

class EnumsController extends Controller
{
    public function skills()
    {
        return \App\Models\Skill::all();
    }

    public function guidelines()
    {
        return \App\Models\Guideline::all();
    }

    public function interests()
    {
        return \App\Models\Interest::all();
    }

    public function countries()
    {
        return \App\Enums\Countries::getValues();
    }

    public function careers()
    {
        return Career::all();
    }

    public function studyLevels()
    {
        return StudyLevel::all();
    }
}
