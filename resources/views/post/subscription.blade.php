{{-- ヘッダー部分の設定 --}}
@extends('app')
@section('content')
 
<div class="container py-3">
  <h3 class="mb-3">ご登録フォーム</h3>
 
{{-- フォーム部分 --}}
<form action="{{route('stripe.afterpay')}}" method="post" id="payment-form">
  @csrf
  
    <label for="exampleInputEmail1">お名前</label>
    <input type="test" class="form-control col-sm-5" id="card-holder-name" required>
 
    <label for="exampleInputPassword1">カード番号</label>
    <div class="form-group MyCardElement col-sm-5" id="card-element"></div>
 
    <div id="card-errors" role="alert" style='color:red'></div>
 
    <button class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">送信する</button>
 
</form>

    契約のキャンセルはこちらから
	<form method="POST" action="{{route('stripe.cancel', $user) }}">
		@csrf
		<button class="btn btn-success mt-2">キャンセルする</button>
	</form>

</div>

<form action="{{route('stripe.portalsubscription', $user) }}">
	<button class="btn btn-primary mb-3">Stripeポータルサイト</button>
</form>

<script src="https://js.stripe.com/v3/"></script>

<script>

	
 
	// HTMLの読み込み完了後に実行するようにする
	window.onload = my_init;
	function my_init() {
		// Configに設定したStripeのAPIキーを読み込む  
		const stripe = Stripe("{{ config('services.stripe.pb_key') }}");
		const elements = stripe.elements();
		var style = {
			base: {
				color: "#32325d",
				fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
				fontSmoothing: "antialiased",
				fontSize: "16px",
				"::placeholder": {
					color: "#aab7c4"
				}
			},
			invalid: {
				color: "#fa755a",
				iconColor: "#fa755a"
			}
		};
		
		const cardElement = elements.create('card', {style: style, hidePostalCode: true});
		cardElement.mount('#card-element');
 
		const cardHolderName = document.getElementById('card-holder-name');
		const cardButton = document.getElementById('card-button');
		const clientSecret = cardButton.dataset.secret;
 
		cardButton.addEventListener('click', async (e) => {
			// formのsubmitボタンのデフォルト動作を無効にする
			e.preventDefault();
			const { setupIntent, error } = await stripe.confirmCardSetup(
				clientSecret, {
					payment_method: {
					card: cardElement,
					billing_details: { name: cardHolderName.value }
					}
				}
			);
			
			if (error) {
			// エラー処理
			console.log('error');
			
			} else {
			// 問題なければ、stripePaymentHandlerへ
			stripePaymentHandler(setupIntent);
			}
		});
	}

	function stripePaymentHandler(setupIntent) {
		console.log("PaymentHandler");
		var form = document.getElementById('payment-form');
		var hiddenInput = document.createElement('input');
		hiddenInput.setAttribute('type', 'hidden');
		hiddenInput.setAttribute('name', 'stripePaymentMethod');
		hiddenInput.setAttribute('value', setupIntent.payment_method);
		form.appendChild(hiddenInput);
		// フォームを送信
		form.submit();
	}

</script>
@endsection