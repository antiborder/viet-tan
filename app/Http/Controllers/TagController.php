<?php

namespace App\Http\Controllers;

use DB;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    public function index()
    {
        $tags = Tag::all();

        $subscription = User::getSubscription();
        return view('tags.index', ['tags' => $tags, 'subscription'=>$subscription ], );

    }

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

        return view('categories.index', ['categories' => $category_names]);
    }

    public function showCategory(string $name)
    {
        $tag_names = config('const.CATEGORIES')[$name]['TAGS'];
        $tags = Tag::wherein('name', $tag_names)->get();

        return view('categories.show', ['category' => config('const.CATEGORIES')[$name] , 'tags' => $tags], );

    }

    public function export_tags(Request $request){
        $task = new Tag;
        $table = $task->getTable();
        $columns = $task->getConnection()->getSchemaBuilder()->getColumnListing($table);
        $header = collect($columns)->implode(",");
        // return $header;
        $selectStr = collect($columns)->map(function($item) {
            return $item;//"ifnull({$item}, '')";
        })->implode(", ',' ,");

        $data = DB::table('tags')
        ->select(DB::raw("concat({$selectStr}) as record"))
         ->pluck("record");
        // ヘッダーとデータを加えて改行コードでつなげて１つの文字列にする
        $text = $data->prepend($header)->implode("\r\n");
        $text = str_replace(array("\n"), ' ', $text);

        return $text;
    }

}