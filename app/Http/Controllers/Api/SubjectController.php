<?php

namespace App\Http\Controllers\Api;

use App\Models\Subject;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function index()
    {
        return Subject::orderBy('sort_order')->get();
    }
}
