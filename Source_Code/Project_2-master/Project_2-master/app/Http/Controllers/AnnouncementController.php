<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('announcement'); // Ensure 'resources/views/announcement.blade.php' exists
    }
}
