<?php

namespace App\Http\Controllers;

use DB;
use App\Tag;
use App\User;
use App\Http\Requests\TagRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{

    public function index()
    {
        if(Auth::id() === 1 ){
            $tags = Tag::all();
            $subscription = User::getSubscription();
            return view('tags.index', ['tags' => $tags, 'subscription'=>$subscription ], );
        }else{
            return redirect()->route('index');
        }

    }

    public function show(string $name)
    {
        $tag = Tag::where('name', $name)->first();

        $subscription = User::getSubscription();
        return view('tags.show', ['tag' => $tag, 'subscription'=>$subscription ], );

    }

    public function edit(string $name)
    {
        if(Auth::id() === 1 ){
            $tag = Tag::where('name', $name)->first();
            $subscription = User::getSubscription();
            return view('tags.edit', ['tag' => $tag, 'subscription'=>$subscription ], );
        }else{
            return redirect()->route('index');
        }
    }

    public function update(TagRequest $request, string $name)
    {
        // file_put_contents('/tmp/log', date('Y-m-d H:i:s') . " [" . __FILE__  . ":" . __LINE__ . "] " . var_export($name, true) . "", FILE_APPEND);
        // return $request;
        // if(Auth::id() === 1 ){
            $tag = Tag::where('name', $name)->first();
            $this->saveTag($request, $tag);
            return redirect()->route('tags.index');
        // }else{
        //     return redirect()->route('index');
        // }
    }

    public function delete(TagRequest $request, string $name)
    {
        if(Auth::id() === 1 ){
            $tag = Tag::where('name', $name)->first();
            $this->saveTag($request, $tag);
            return redirect()->route('tags.index');
        }else{
            return redirect()->route('index');
        }
    }
    
    public function destroy(string $name)
    {
        if(Auth::id() === 1 ){
            $tag = Tag::where('name', $name)->first();            
            $tag->delete();
            return redirect()->route('tags.index');
        }else{
            return redirect()->route('index');
        }        

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

    private function saveTag(TagRequest $request, Tag $tag)
    {
        $tag->fill(['keywords' => $request->keywords]);
        $tag->save();
    }


}