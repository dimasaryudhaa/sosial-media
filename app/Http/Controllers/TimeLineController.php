<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class TimeLineController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'posts' => Post::with('user')
                ->withCount('comments')
                ->latest('id')
                ->whereNull('deleted_at') 
                ->get(),
        ]);
    }
    
}
