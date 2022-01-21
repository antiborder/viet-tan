<form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<input type="file" name="file">
		<br><br>
		<button class="btn btn-success">import</button>
	</div>
</form>
<br><br>
<form action="{{ route('clear') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<button class="btn btn-success">clear all</button>
	</div>
</form>

<form action="{{ route('trim') }}" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="form-group">
		<button class="btn btn-success">delete data with no level</button>
	</div>
</form>
