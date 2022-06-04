<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function show(Request $request, string $name)
    {
        $tag = Tag::where('name', $name)->first();
        return view('tags.show', ['tag' => $tag], ['request' => $request]);
        
    }

    public function category()
    {
        $tags = Tag::all();
        return view('tags.category', ['tags' => $tags]);
    }

}
