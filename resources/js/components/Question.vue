//** 意味⇒単語の実装。
//熟練度にtimeの影響も反映。
//** 総復習モードも実装。 レベル選定はゲージで。modalで。
//ドメイン登録。 sendgrid実装。
//** 単語読み上げ
//本番環境でもgoogleログインできるように。
//学習中にレベル別習熟度を表示。
//ユーザ管理。権限レベル毎に管理。個人ページは本人と管理者しか見れないように。
//***課金システム
//toppageにはお知らせ。
//toppageにアプリ説明。
//10語毎に一息入れる。連続で正解すると何か出る。
//level11でエラーが出る単語：紺色とスポンジ。意味が???になる単語：劇 この他に、詳細が出ない単語が結構ある。level7でエラーが出る単語：インド、紫、枕。
//Googleadsense
//エクスポート機能
//前の単語を隅っこに表示。
//選択肢からanswerの類義語を取り除く
//ユーザー名は英数字のみに。
//ssl認証
//Googleadsense
//ユーザ権限を考慮したランダムモード実装
//様々なパラメータを定数化。単語の音節数とか、タグ数とか、問題の選択肢の数だとか。
//Ｎ+1問題。
//学習単語がなくなった時の処理と、今日の学習完了の判定条件。とメッセージ。学習完了メッセージとその後のrouteをもっと真面目にやる。おすすめレベルなど。
//タグ一覧
//ベトナム語検索結果を部分一致と全体一致に分ける。表示順序や表示数もちょうせい。
//WordControllerのupdate、create、importの共通部分をまとめたい。
//テスト実装
//時刻はどの場所の時刻になるのか、ぶれないように確認必要。
//代入には$setを使う。
//.emvのAPP_URLは最終的には製品版のURLを入れる。教材6-5「パスワード再設定メール(テキスト版)のテンプレートの作成」


<template>
  <div class="mx-auto" style="text-align:center; max-width:800px;">
    <div style="text-align:left">
      Lv.:{{level}}　正解率: {{correct}} / {{total}} {{status}} {{isCorrect}}
    </div>
    <div v-if="status==='CLEARED'" class="card white rounded mt-5 mx-auto" style="width:200px">
      cleared!!
      <a v-bind:href="'/users/'+user_name">
        学習状況を確認
      </a>
    </div>    
    <div class="mt-1 d-flex flex-row" style=" height: 55px;">
      <div v-bind:class="result_text_color" class="text-nowrap pt-1" style="text-align:left;   width:20%; font-size: 1.0rem;  "> 
        {{result_text}}
      </div>
      <div v-if="status==='JUDGED' || status==='ANSWERED' || status==='PROMPT' "class="card white rounded"  style="width:60%; display:table;">
        <span v-if="mode === 'VtoM'" class="h4 mt-1 bounce" style="vertical-align:middle; display:table-cell;">{{answer}}</span>
        <span v-if="mode === 'MtoV'" class="h5 mt-1 bounce" style="white-space: pre-line; vertical-align:middle; display:table-cell;">{{answer_M}}</span>
      </div>
    </div>

    <div v-if=" status==='ANSWERED' " class="mt-1 mb-1" style="text-align:left; max-width:650px">
      <span class="pt-2 text-nowrap;" style = "min-width:70px; text-align:left; font-size: 0.9rem;">
        覚えた？
      </span>      
      <span v-for="i in [0,1,2,3]" style = " text-align:center;">
        <span v-if=" isCorrect===true || i===0">
          <button @click="clickButton(i)" type="button" v-bind:class="colors[i]" class="btn btn-sm rounded pt-1 pb-1 px-2 text-nowrap"style="min-height:40px; max-width: 100px; font-size: 0.9em;">
            {{button_properties[i].text}}
          </button>
        </span>
      </span>
    </div>    

    <div v-if="status==='LOADING' || status==='PROMPT' || status==='JUDGED' " class="pt-2" style=" text-align:center; height: 60px;">
      <span>
        {{message}}
      </span>
    </div>
    <div v-if="status==='INITIAL'" style=" text-align:center;">
      <input v-model="level" placeholder="Choose level">
      <div class="" style = "text-align:center; height: 80px;">
        <button @click="clickStart()" type="button" class="btn btn-info orange m-5 lighten-1 rounded pb-1 text-nowrap"style="max-width: 240px; font-size: 1.6rem;">
          START
        </button>
      </div>
    </div>      

    <div v-if="status==='PROMPT' || status === 'JUDGED' || status ==='ANSWERED'" class="" >    
      <div class="mx-auto" style="max-width:545px">
        <div v-for="i in [0,1,2,3]">

          <Choice :mode ="mode" :word = "choices[i].word" :isAnswer = "choices[i].isAnswer" :status = "status" :sec = "sec" v-on:pressed = "turnPressed(i)"/>

        </div>
      </div>
    </div>
    <div v-if="status==='JUDGED' || status==='ANSWERED' || status==='PROMPT' " style="text-align:center">
      {{sec}}
    </div>
  </div>
</template>

<script>
  import Choice from './Choice.vue'
  export default {

    components: {
      Choice
    },
    data(){
      return {
        rootURL:location.hostname,
        mode: "MtoV",
        answer: " ",
        answer_M: " ",
        status : "INITIAL",
        sec: 0,
        timerOn: false, 
        timerObj: null,
        choices:[],
        level: this.initial_level,
        total:0,
        correct:0,
        isCorrect: null,
        button_properties:[
          { text:"まだ。"},
          { text:"びみょう..."},
          { text:"覚えた!"},
          { text:"余裕♪"},
        ],
      }
    },

    computed: {
      buttonText: function () {
        if(this.status==="INITIAL"){
          return "START ▶";
        }else if(this.status==="LOADING"){
          return "";
        }else if(this.status==="PROMPT"){
          return "";
        }else if(this.status==="JUDGED"){
          return "NEXT ▶";
        }
      },
      message: function () {
        if(this.status==="INITIAL"){
          return "";
        }else if(this.status==="LOADING"){
          return "Now Loading";
        }else if(this.status==="PROMPT"){
          return "単語の意味を選んでください";
        }else if(this.status==="JUDGED"){
          return "正解を選んでください";
        }else if(this.status==="ANSWERED"){
          return "";
        }        
      },
      result_text: function(){
        if(this.isCorrect == true){
          return "正解";
        }else if(this.isCorrect == false){
          if(this.sec<10){
            return "不正解";
          }else{
            return "時間切れ";
          }
        }else{
          return "";
        }
      },
      result_text_color: function(){
        if(this.isCorrect == true){
          return "text-success";
        }else if(this.isCorrect == false){
          return "text-danger";
        }else{
          return "";
        }
      },
      recommendation: function(){
        if(this.status === "JUDGED" || this.status==="ANSWERED"){
          if(this.isCorrect){
            if(this.sec < 2){
              return 3;
            }else if(this.sec <3){
              return 2;
            }else{
              return 1;
            }
          }else{
            return 0;
          }
        }else{
          return null;
        }

      },
      colors: function(){
        const baseColors = [" yellow accent-1", " yellow accent-2", "yellow accent-3", "yellow accent-4"];
        let colors = [];
        for(let i=0;i<=3;i++){
          if(i === this.recommendation){
            colors.push(baseColors[i]+" animated bounceIn");
          }else{
            colors.push("grey"+" lighten-2");
          }
        }
      return colors;
      },
    },

    watch: {
      sec: function(val) { //制限時間を過ぎたら不正解
        if( val>=10 && this.status === "PROMPT"){
          this.stopTimer();
          this.status = "JUDGED";
          this.isCorrect = false;
          this.total +=1;  
        }
      },
    },

    props: {
      endpoint_to_get_word: {
        type: String,
      },
      endpoint_to_record_learn: {
        type: String,
      },
      user_name: {
        type: String,
      },  
      initial_level:{
        type: String,
      }    
    },
    
    methods: {

      clickStart() { //学習開始のボタンをクリック
        console.log("START pressed");
        this.status = "LOADING";        
        this.isCorrect = null;
        this.getWords();        
      },

      clickButton(n) { //次の単語に進むボタンをクリック
        this.sec = 0;        
        this.recordLearn(n);
        this.status = "LOADING";        
        this.isCorrect = null;
        this.getWords();
      },

      async recordLearn(n) { //学習を記録
        const response = await axios.post(this.endpoint_to_record_learn,
          {
            name: this.answer,
            result: this.isCorrect, 
            easiness: n,
          }
        ).then(response => {
          console.log('status:', response.status); // 200
          console.log('data:', response.data); //
        }).catch(err => {
          console.log('err:', err);
        });        
      },
      
      async getWords() { //次の単語を取得
        const response = await axios.get(this.endpoint_to_get_word, {
          params:{ level: this.level,
                    previous: this.answer }
        });
        //本来はきれいなjsonで来てほしいが、dataの頭に全角スペースが入ることもあるため、どちらでもいいように場合分けしている。
        if(response.data === "CLEARED"){
          this.status = "CLEARED";
          return;
        }
        let jsoned;
        if(String(response.data).substr(0,1) == '　'){
          let trimed = response.data.replace(/　+/g,'');
          jsoned = JSON.parse(trimed);        
        }else{
          jsoned = response.data;
        }

        for(let i=0;i<3; i++){
          this.choices[i] = {
            'word':this.formatWord(jsoned.others[i]),
            'isAnswer':false,
          }
        }
        this.choices[3] = {
          'word':this.formatWord(jsoned.answer), 
          'isAnswer':true,
        }        

        let random = 0
        if(this.mode = "VtoM"){
          random = Math.floor( Math.random() + 0.2)
        }else if(this.mode = "MtoV"){
          random = Math.floor( Math.random() + 0.8)
        }
        this.mode = ["VtoM", "MtoV"][random]

        this.answer = this.formatWord(jsoned.answer).syllables.join(" ");
        this.answer_M = this.formatWord(jsoned.answer).jp;
        this.choices = this.arrayShuffle(this.choices)
        this.status = "PROMPT";        
        this.startTimer();        
      },
      
      formatWord(word) {
        let syllables ='["'+word.syllables+'"]';
        syllables = JSON.parse(syllables.replace(/,/g, '","'));
        let kanjis ='["'+word.kanjis+'"]';
        kanjis = JSON.parse(kanjis.replace(/,/g, '","'));
        
        return {
          syllables:syllables,
          kanjis:kanjis,
          jp:word.jp,
          level:word.level,
          id:word.id,
        }       
      },

      arrayShuffle(array) { // 要素を並び替える
        for(var i = (array.length - 1); 0 < i; i--){
          var r = Math.floor(Math.random() * (i + 1));
          var tmp = array[i];
          array[i] = array[r];
          array[r] = tmp;
        }
        return array;
      },
      
      turnPressed(n){  //選択肢がクリックされた時のアクション

        if(this.status === "PROMPT"){
          this.stopTimer();
          if(this.choices[n].isAnswer === true){
            this.isCorrect = true
            this.status = 'ANSWERED'
          }else if(this.choices[n].isAnswer === false){
            this.isCorrect = false
            this.status = 'JUDGED'
          }
          
        }else if(this.status === "JUDGED"){
          if(this.choices[n].isAnswer === true){
            this.status = "ANSWERED"
          }
        }
      },

      count(){
        this.sec++;
      },

      startTimer(){
        let self = this;        
        this.timerObj = setInterval(function() {self.count()},1000)
        this.timerOn = true;
      },

      stopTimer(){
        clearInterval(this.timerObj);
        this.timerOn = false;
      },
    },  
    
  }
</script>