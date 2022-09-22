<div class="category-card">
    <a class="text-dark text-left ml-1" href="{{ route('categories.show', ['name' => $category]) }}" style=" position:absolute; font-size:1.2rem; top: 0; left: 0; width: 100%; height: 100%;">
        {{config('const.CATEGORIES')[$category]['NAME']}}
        <img class="mt-3"src="{{'/image/'.config('const.CATEGORIES')[$category]['IMAGES'][0]}}" style="height:120px; position:absolute; left:10px; top:30px">
    </a>
</div>