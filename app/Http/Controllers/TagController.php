<?php

namespace App\Http\Controllers;

use DB;
use App\Tag;
use App\User;
use App\Http\Requests\TagRequest;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Goodby\CSV\Import\Standard\LexerConfig;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;

class TagController extends Controller
{

    public function index()
    {
        if(Auth::id() === 1 ){
            $tags = Tag::all()->sortBy('id');
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
        if(Auth::id() === 1 ){
            $tag = Tag::where('name', $name)->first();
            $this->saveTag($request, $tag);
            return redirect()->route('tags.index');
        }else{
            return redirect()->route('index');
        }
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


    public function import(Request $request)
    {
        // CSV ファイル保存
        $tmpName = mt_rand().".".$request->file('file')->guessExtension(); //TMPファイル名
        $request->file('file')->move(public_path()."/csv/tmp",$tmpName);
        $tmpPath = public_path()."/csv/tmp/".$tmpName;

        //Goodby CSVのconfig設定
        $config = new LexerConfig();
        $interpreter = new Interpreter();
        $lexer = new Lexer($config);

        //CharsetをUTF-8に変換、CSVのヘッダー行を無視
        $config->setToCharset("UTF-8");
        $config->setFromCharset("UTF-8");
        $config->setIgnoreHeaderLine(true);

        $dataList = [];

        // 新規Observerとして、$dataList配列に値を代入
        $interpreter->addObserver(function (array $row) use (&$dataList){
            // 各列のデータを取得
            $dataList[] = $row;
        });

        // CSVデータをパース
        $lexer->parse($tmpPath, $interpreter);

        // TMPファイル削除
        unlink($tmpPath);

        // 登録処理
        $count = 0;
        foreach($dataList as $row){
            $tag = Tag::where('name',$row[0]) ->first();
            if($tag){
                $tag->fill([
                    'name' => $row[0],
                    'keywords' => $row[1],
                ]);
                $count++;
                $tag->save();
            }
        }

        // return $dataList;
        return redirect()->action('TagController@index')->with('flash_message', 'keywordを' . $count . '個登録しました！');
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