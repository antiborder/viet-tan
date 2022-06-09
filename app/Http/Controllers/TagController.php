<?php

namespace App\Http\Controllers;

use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function show(string $name)
    {
        $tag = Tag::where('name', $name)->first();

        $subscription = User::getSubscription();
        return view('tags.show', ['tag' => $tag, 'subscription'=>$subscription ], );
        
    }

    public function showCategories()
    {
        $categories = config('const.CATEGORIES');
        $category_names = array();
        foreach($categories as $category_name => $category){
            $category_names[] = $category_name;
        }

        return view('tags.categories', ['categories' => $category_names]);
    }

    public function showCategory(string $name)
    {
        $tag_names = config('const.CATEGORIES')[$name]['TAGS'];
        $tags = Tag::wherein('name', $tag_names)->get();

        return view('tags.category', ['category' => config('const.CATEGORIES')[$name] , 'tags' => $tags], );
        
    }    

}