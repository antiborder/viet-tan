{{-- ヘッダー部分の設定 --}}
@extends('app')
@section('content')
 
<div class="container py-3">
    契約のキャンセルはこちらから
	<form method="POST" action="{{route('stripe.cancel', $user) }}">
		@csrf
		<button class="btn btn-success mt-2">キャンセルする</button>
	</form>
</div>



@endsection