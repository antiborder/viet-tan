//類義語対義語の数を20個くらいに増やす。
//googleSearchConsoleなど。
//ssl認証
//***課金システム。terms of use。privacy policy。
//toppageにアプリ説明。と学習の使い方。トップページとナビバーレイアウト。ロゴ。
//toppageにはお知らせ。レベル表。
//問い合わせフォーム。
//検索機能：音節が類似も載せたい。
//loadingのときのグルグルマーク
//ユーザー名は英数字のみに。
//ユーザ管理。権限レベル毎に管理。個人ページは本人と管理者しか見れないように。検索結果の表示をレベル毎に変える。
//理解度ボタンにおおよその時間数日数を表示。おすすめレベル。
//Googleadsense
//過去24時間以内で生まれた学習計画
//チョイスのスピーカーマークで音声再生。
//単語力測定
//例文のデータベース
//正解すると学習がデータベースに登録されずにまた出題されるエラー？
//数字集中トレーニング。
//level11でエラーが出る単語：紺色とスポンジ。意味が???になる単語：劇 この他に、詳細が出ない単語が結構ある。level7でエラーが出る単語：インド、紫、枕。level4でエラーが出る単語：黄色。
//ユーザ権限を考慮したランダムモード実装。学習計画からレベルごとに非表示する機能。レベルごとに履歴消去の機能。
//様々なパラメータを定数化。単語の音節数とか、タグ数とか、問題の選択肢の数だとか。類義語などの数を増やす。
//Ｎ+1問題。
//学習単語がなくなった時の処理と、今日の学習完了の判定条件。とメッセージ。学習完了メッセージとその後のrouteをもっと真面目にやる。
//タグ一覧
//WordControllerのupdate、create、importの共通部分をまとめたい。
//単語力測定結果をtwitterに報告。facebookに報告。レベル上昇も報告。
//テスト実装

//時刻はどの場所の時刻になるのか、ぶれないように確認必要。
//代入には$setを使う。
//.emvのAPP_URLは最終的には製品版のURLを入れる。教材6-5「パスワード再設定メール(テキスト版)のテンプレートの作成」
//詳細が表示されない不具合⇒変なタグが入っていたのが原因

<template>
  <div class="mx-auto" style="text-align:center; max-width:700px;">
    <div style="text-align:left">
      Lv.:{{level}}　正解率: {{correct}} / {{total}} {{status}}
    </div>

    <!-- 最初の画面 -->
    <div v-if="status==='INITIAL'" class="mx-auto" style=" text-align:center;max-width:400px">
      <div class="card white rounded" style="max-width: 400px;">
        <div class="card-body" style = "text-align:center;">
          <div class="m-2 p-2" style="font-size:1.2rem">
            レベルを選択：
            <select size="1" v-model= "level" class="m-2" style="width:100px;">
              <option v-for="i in 12" >{{i}}</option>
              <option v-if="user_name!==''"value="REVIEW_ALL">復習のみ</option>
            </select> 
          </div>
          <div class="mt-4 p-1">
            <button @click="clickStart()" type="button" class="btn btn-info orange lighten-1 rounded p-1 text-nowrap"style="width: 220px; font-size: 1.5rem;">
              START ▶
            </button>
          </div>
          <div class="text-primary" style="height:50px;">
            <span v-if="level==='REVIEW_ALL'">
              「復習のみ」では、復習可能語が<br>
              すべてのレベルから出題されます。
            </span>            
          </div>          
        </div>
      </div>
    </div>          

    <!-- 出題画面 -->        
    <div v-if="status!=='RESULT' && status!=='CLEARED'" class="mt-1 d-flex flex-row" style=" height: 55px;">
      <div v-bind:class="result_text_color" class="text-nowrap pt-1" style="text-align:left; width:20%; font-size: 1.0rem;"> 
        {{result_text}}
      </div>
      <div v-if="status==='JUDGED' || status==='ANSWERED' || status==='PROMPT' "class="card white rounded"  style="width:60%; display:table;">
        <span v-if="mode === 'FM'" class="h4 mt-1 bounce" style="vertical-align:middle; display:table-cell;">{{answer_F}}</span>
        <span v-if="mode === 'MF'" class="h5 mt-1 bounce" style="white-space: pre-line; vertical-align:middle; display:table-cell;">{{answer_M}}</span>
      </div>
    </div>
    <!-- 自己評価ボタン -->
    <div v-if=" status==='ANSWERED' " class="mt-1 mb-1" style="text-align:left; max-width:500px; margin:auto">
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

    <!-- メッセージ -->
    <div v-if="status==='LOADING' || status==='PROMPT' || status==='JUDGED' " class="pt-2" style=" text-align:center; height: 60px;">
      <span>
        {{message}}
      </span>
    </div>

    <!-- 選択肢 -->
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

    <!-- 結果表示 RESULT and CLEARED-->
    <div v-if="status==='RESULT' || status==='CLEARED' " class="card white rounded mt-5 mx-auto" style="text-align:center; max-width:400px; font-size: 1.2 rem;">
      <div class="card-body" >
        <div v-if="total > 0" class="mb-2">
          <div class="text-muted" style="font-size:0.8rem">単語をクリックすると詳細ページが開きます。</div>
          <table class="blue-grey lighten-5 rounded" style="margin:auto; border-collapse: separate; border-spacing: 0px 0px; min-width:90%">
            <tr >
              <th></th>
              <th style="min-width:70%">単語</th>
              <th>level</th>
              <th>結果</th>
            </tr >          
            <tr v-for="e in this.history">
              <td>{{e.No}}</td>
              <td style="font-size:1.3rem">
                <a v-bind:href="'/words/'+e.id" class="white text-dark rounded" type="button" target="_blank" rel="noopener noreferrer">
                &nbsp;{{e.name}}&nbsp;
                </a>
              </td>
              <td v-if="e.level==='REVIEW_ALL'" style="font-size:1.0rem">
                復習
              </td>
              <td v-else style="font-size:1.0em">
                {{e.level}}
              </td>
              <td>
                <button type="button" v-bind:class="baseColors[e.easiness]" class="btn btn-sm rounded pt-1 pb-1 px-2 text-dark text-nowrap shadow-none"style="height:27px; max-width: 100px; font-size: 0.8rem;">
                  {{button_properties[e.easiness].text}}
                </button>
              </td>            
            </tr>
          </table>
          <div style="text-align:right">正解率： {{correct}}/{{total}}</div>
        </div>
        
        <div v-if="status==='CLEARED'">
          <div v-if="level==='REVIEW_ALL'" class="mt-1 mb-1" >
            現時点で復習可能な単語は以上です。
          </div>
          <div v-else class="mt-1 mb-1">
            レベル{{level}}の単語は以上です。
          </div>
        </div>
        <div v-if="status==='RESULT' ">
          <button @click="clickStart()" type="button" class="btn btn-info light-blue accent-4 rounded p-1 mt-3 text-nowrap" style="width: 240px; font-size: 1.3rem;">
            続ける ▶
          </button>
        </div>
        <div v-if="status==='RESULT'">
          <div v-if="this.user_name===''">
            <a type="button" href="/" class="btn btn-info orange lighten-1 rounded p-1 mt-2 text-nowrap" style="width: 240px; font-size: 1.3rem;">
              Topページに戻る
            </a>
          </div>
        </div>
        <div v-if="this.user_name!==''">
          <a type="button" class="btn btn-info orange lighten-1 rounded p-1 mt-2 text-nowrap" style="width: 240px; font-size: 1.3rem;" v-bind:href="'/users/'+user_name">
            学習状況を確認
          </a>
        </div>
        <div v-if="status==='CLEARED' ">
          <button @click="initialize()" type="button" class="btn btn-info light-blue accent-4 rounded p-1 mt-2 text-nowrap" style="width: 240px; font-size: 1.3rem;">
            レベルを変更
          </button>
        </div>              
      </div>
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
        mode: "MF",
        answer_F: " ",
        answer_M: " ",
        answer_id: 0,
        answer_level: 1,
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
          { text:"びみょう"},
          { text:"覚えた!"},
          { text:"余裕♪"},
        ],
        history:[],
        baseColors:[" red lighten-4", " yellow lighten-4", " green lighten-4", " blue lighten-4"],
      }
    },

    computed: {
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
          if(this.sec < Number(this.time_limit)){
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
        // const baseColors = [" green accent-1", " green accent-2", "green accent-3", "green accent-4 text-white"];
        let colors = [];
        for(let i=0;i<=3;i++){
          if(i === this.recommendation){
            colors.push(this.baseColors[i]+" animated bounceIn");
          }else{
            colors.push("grey"+" lighten-2");
          }
        }
      return colors;
      },
    },

    watch: {
      sec: function(val) { //制限時間を過ぎたら不正解
        if( val>=Number(this.time_limit) && this.status === "PROMPT"){
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
      },
      time_limit:{
        type: String,
      },
    },
    
    methods: {

      clickStart() { //学習開始のボタンをクリック
        console.log("START pressed");
        this.status = "LOADING";        
        this.isCorrect = null;
        this.total = 0;
        this.history = [];
        this.correct = 0;
        this.getWords();        
      },

      initialize(){ //最初の画面に戻る
        console.log("initialize");
        this.status = "INITIAL";
        this.isCorrect = null;
        this.total = 0;
        this.history = [];
        this.correct = 0;        
      },

      clickButton(n) { //次の単語に進むボタンをクリック
        this.sec = 0;
        this.history.push({'No':this.total, 'name':this.answer_F, 'easiness':n, 'level':this.answer_level, 'id':this.answer_id});
        this.recordLearn(n);
        if(this.total >= 10){
          this.status = "RESULT"
          this.isCorrect = null;

          let result_sound = new Audio('/sound/result.mp3');
          result_sound.volume = 0.3;
          result_sound.play();          
        }else{
          this.status = "LOADING";        
          this.isCorrect = null;
          this.getWords();
        }
      },

      async recordLearn(n) { //学習を記録
        const response = await axios.post(this.endpoint_to_record_learn,
          {
            name: this.answer_F,
            result: this.isCorrect, 
            easiness: n,
            sec: this.sec,
            mode: this.mode,
          }
        ).then(response => {
          console.log('status:', response.status); // 200
          console.log('data:', response.data); //
          console.log('response:', response); //
        }).catch(err => {
          console.log('err:', err);
        });        
      },
      
      async getWords() { //次の単語を取得
        const response = await axios.get(this.endpoint_to_get_word, {
          params:{ level: this.level,
                    previous: this.answer_F }
        });
        //本来はきれいなjsonで来てほしいが、dataの頭に全角スペースが入ることもあるため、どちらでもいいように場合分けしている。
        if(response.data === "CLEARED"){
          this.status = "CLEARED";
          let clear_sound = new Audio('/sound/clear.mp3');
          clear_sound.volume = 0.3;
          clear_sound.play();                    
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

        this.mode = jsoned.mode
        let formated = this.formatWord(jsoned.answer)
        this.answer_F = formated.syllables.join(" ");
        this.answer_M = formated.jp;
        this.answer_id = formated.id;
        this.answer_level = formated.level;

        let question_sound = new Audio('/sound/question1.mp3');
        question_sound.volume = 0.3;
        question_sound.play();

        if(this.mode ==="FM"){
          let answer_voice = new Audio('/sound/word/' + this.answer_id + '.mp3');
          answer_voice.volume = 1.0;
          answer_voice.play();

        }
        this.choices = this.arrayShuffle(this.choices)
        setTimeout(() => {
          this.status = "PROMPT";        
          this.startTimer();        
        },200)
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
            this.total++
            this.correct++
          }else if(this.choices[n].isAnswer === false){
            this.isCorrect = false
            this.status = 'JUDGED'
            this.total++
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