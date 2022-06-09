@extends('app')

@section('title', '通常会員ご登録')

@section('content')

<div class="container">
    <div class="row">
      <div class="mx-auto col col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
        <h1 class="text-center"><a class="text-dark" href="/">べとらん</a></h1>
        <div class="card mt-3">
          <div class="card-body">
            <h2 class="h3 card-title text-center mt-2">通常会員 ご登録</h2>
            <div class="card-text">
			<form action="{{route('stripe.afterpay')}}" method="post" id="payment-form">
				@csrf
							
				<label for="exampleInputEmail1" class="">お名前</label>
				<input type="text" class="form-control col-sm-12 mb-3" id="card-holder-name" required >
			
				<label for="exampleInputPassword1">カード番号</label>
				<div class="form-group MyCardElement col-sm-12 border" id="card-element" ></div>
			
				<div id="card-errors" role="alert" style='color:red'></div>
			
				<button class="btn btn-block btn-info deep-orange lighten-1 mt-2 mb-2" id="card-button" style="font-size:1.1rem" data-secret="{{ $intent->client_secret }}">送信する</button>
			</form>				
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <form action="{{route('stripe.portalsubscription', $user) }}">
     <button class="btn btn-primary">Stripeポータルサイト</button>
   </form> -->
 

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