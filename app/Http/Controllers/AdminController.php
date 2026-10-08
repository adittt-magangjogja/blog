<?php

namespace App\Http\Controllers;

use App\Models\Post;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalPosts = Post::count();

        return view('admin.dashboard', compact('totalPosts'));
    }
}