//wordのnameからrouteでurl取得。
//単語更新でタグがない単語に空のタグが登録されるのを防止。
//ユーザー一覧用の画面。//user毎の利用状況を一覧できる画面。
//adblock対策
//単語編集でタグも編集
//広告の種類を増やす。measureも広告を交互に変える。
//各カテゴリとタグのキーワードも表示。検索にカテゴリも引っかかるように。
//ロゴ配置。//スモールアイコンの画像。
//理解度ボタンにおおよその時間数日数を表示。おすすめレベル。
//検索機能：音節が類似も載せたい。->service層をつくるか。
//過去24時間以内で生まれた学習計画
//articleリスト。どの単語から、学習全体マップ。ベトナム語ってどんな言語。覚えるためには繰り返し。習慣化が大事。単語の意味と訳語。通じないときの原因は。
//FAQ レベルについて、運営者について、支払いについて、不具合について　料金はいくらですか？　いつでもキャンセルできますか？
//南部/北部を除外する
//resultの結果次第でメッセージ。
//例文のデータベース
//数字集中トレーニング。
//単語力測定結果をtwitterに報告。facebookに報告。レベル上昇も報告。
//My単語帳機能。
//webhookに頼らない実装。前回更新日や次回更新日の連絡も。二重契約にならないように。料金表。決済ページに価格を表示。
//実際に課金してみるテスト

//正解すると学習がデータベースに登録されずにまた出題されるエラー？
//terms of use。自動更新のチェックボックスや注意書きは必要なのか？
//無料会員ならば、navに本登録を表示。
//課金解禁
//チョイスのスピーカーマークで音声再生。
//割引プラン実装。
//メール認証は必要？
//数字集中トレーニング。
//level11でエラーが出る単語：紺色とスポンジ。意味が???になる単語：劇 この他に、詳細が出ない単語が結構ある。level7でエラーが出る単語：インド、紫、枕。level4でエラーが出る単語：黄色。
//ユーザ権限を考慮したランダムモード実装。学習計画からレベルごとに非表示する機能。レベルごとに履歴消去の機能。
//Ｎ+1問題。
//exportに類義語と対義語を入れる。
//WordControllerのupdate、create、importの共通部分をまとめたい。
//テスト実装

//時刻はどの場所の時刻になるのか、ぶれないように確認必要。
//代入には$setを使う。
//.emvのAPP_URLは最終的には製品版のURLを入れる。教材6-5「パスワード再設定メール(テキスト版)のテンプレートの作成」
//詳細が表示されない不具合⇒変なタグが入っていたのが原因

<template>
  <div class="mx-auto" style="text-align:center; max-width:700px;">
    <div class="normal-text mt-1" style="text-align:left">
      単語Lv.:{{level}}　正解率: {{correct}} / {{total}} 
      <span>
        <button data-toggle="modal" data-target="#learn-description" class="border border-success text-success rounded ml-2 my-1 py-0 px-1" style="font-family: 'Kosugi Maru', sans-serif;">
          <small>単語学習の使い方</small>
        </button>                        
      </span>
    </div>

    <!-- 最初の画面 -->
    <div v-if="status==='INITIAL'" class="mx-auto" style=" text-align:center;max-width:400px">
      <div class="card white rounded" style="max-width: 400px;">
        <div class="card-body" style = "text-align:center;">
          <div class="m-2 p-2" style="font-size:1.2rem">
            レベルを選択：
            <select size="1" v-model= "level" class="m-2" style="width:100px;">
              <option v-for="i in Number(max_level)" >{{i}}</option>
              <option v-if="user_name!==''"value="REVIEW_ALL">復習のみ</option>
            </select> 
          </div>
          <div class="mt-4 p-1">
            <button @click="clickStart()" type="button" class="btn btn-primary rounded p-1 text-nowrap"style="width: 220px; font-size: 1.5rem;">
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

      <Adsense
        class="adsbygoogle my-2 box-shadow"
        style="display:block;"
        data-ad-client="ca-pub-9067426465896411"
        data-ad-slot="5284563145"
        data-ad-format="rectangle"
        data-full-width-responsive="true"
      >
      </Adsense>

    </div>          

    <!-- 無料登録を勧める -->
    <div v-if="status==='WARN_RANDOM'" class="mx-auto" style=" text-align:center;max-width:400px">
      <div class="card white rounded" style="max-width: 400px;">
        <div class="card-body" style = "text-align:center;">
          <div class="m-2 p-2" style="font-size:1.0rem">
            ログインしていないため、ランダムに出題されます。<br><br>
            <span  style="color:#ff7043">無料登録すれば、単語毎の学習スケジュールに基づいて出題されます。</span>
          </div>
          <div class="mb-3" style="text-align:center; font-size:1.3rem" >
            <a href="/register" class="deep-orange lighten-1 text-white rounded px-4 py-2" >無料登録する</a>
          </div>
          <div class="m-3" style="text-align:center; font-size:1.3rem" >
            <a href="login" class="rounded px-4 py-2" style="color:#ffa726;border-color:#ffa726;border-style:solid">ログインする</a>
          </div>          
          <button @click="load()" type="button" class="btn btn-info light-blue accent-4 rounded px-3 py-2 mt-3 text-nowrap shadow-none "style="font-size: 1.0rem;">
            ランダムでStart ▶
          </button>
        </div>
      </div>
    </div>              

    <!-- 通常会員登録を勧める -->
    <div v-if="status==='RECOMMEND_NORMAL'" class="mx-auto" style=" text-align:center;max-width:400px">
      <div class="card white rounded" style="max-width: 400px;">
        <div class="card-body" style = "text-align:center;">
          <div class="m-2 p-2" style="font-size:1.2rem">
            レベル{{Number(trial_level)+1}}以上は通常会員専用です。
          </div>
          <div class="m-3" style="text-align:center; font-size:1.3rem" >
            <a href="/subscription" class="deep-orange lighten-1 text-white rounded px-5 py-2" >通常会員に登録</a>
          </div>            
          <div class="m-3" style="text-align:center;" >
            <button @click="initialize()" type="button" class="btn btn-info light-blue accent-4 rounded px-5 py-1 mt-2 text-nowrap shadow-none" style=" font-size: 1.3rem;">
              レベルを変更
            </button>
          </div>                      
        </div>
      </div>
    </div>              

    <!-- お試し会員登録を勧める -->
    <div v-if="status==='RECOMMEND_TRIAL'" class="mx-auto" style=" text-align:center;max-width:400px">
      <div class="card white rounded" style="max-width: 400px;">
        <div class="card-body" style = "text-align:center;">
          <div class="m-2 p-2" style="font-size:1.2rem">
            レベル{{Number(guest_level)+1}}以上は会員専用です。
          </div>
          <div class="m-3" style="text-align:center; font-size:1.3rem" >
            <a href="/register" class="deep-orange lighten-1 text-white rounded px-5 py-2" >無料登録する</a>
          </div>            
          <div class="m-3" style="text-align:center;" >
            <button @click="initialize()" type="button" class="btn btn-info light-blue accent-4 rounded px-5 py-1 mt-2 text-nowrap shadow-none" style=" font-size: 1.3rem;">
              レベルを変更
            </button>
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
    <div v-if="status==='LOADING' " class="spinner-border text-muted " role="status" style="width: 3rem; height: 3rem;">
      <span class="sr-only">Loading...</span>
    </div>    
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
      <div v-if="total%2 === 0">
        <Adsense
          class="adsbygoogle my-2 box-shadow"
          style="display:block; min-width:250px"
          data-ad-client="ca-pub-9067426465896411"
          data-ad-slot="5078046569"
          data-ad-format="horizontal"
          data-full-width-responsive="true"
        >
        </Adsense>
      </div>
      <div v-else>
        <Adsense
          class="adsbygoogle my-2 box-shadow"
          style="display:block;"
          data-ad-client="ca-pub-9067426465896411"
          data-ad-slot="5284563145"
          data-ad-format="rectangle"
          data-full-width-responsive="true"
        >
        </Adsense>
      </div>  
    </div>


    <!-- 結果表示 RESULT and CLEARED-->
    <div v-if="status==='RESULT' || status==='CLEARED' ">    
      <div class="card white rounded mt-5 mx-auto" style="text-align:center; max-width:400px; font-size: 1.2 rem;">
        <div class="card-body" >
          <div v-if="total > 0" class="mb-2">
            <div class="text-muted" style="font-size:0.8rem">単語をクリックすると詳細ページが開きます。</div>
            <table class="normal-text blue-grey lighten-5 rounded rounded-4" style="margin:auto; border-collapse: separate; border-spacing: 0px 0px; min-width:90%">
              <tr >
                <th></th>
                <th style="min-width:70%">単語</th>
                <th>level</th>
                <th>結果</th>
              </tr >          
              <tr v-for="e in this.history">
                <td>{{e.No}}</td>
                <td style="font-size:1.3rem">
                  <a v-bind:href="'/words/'+e.id" class="white viet-text text-dark rounded rounded-4" type="button" target="_blank" rel="noopener noreferrer">
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
            <div class="px-2" style="text-align:right">正解率： {{correct}}/{{total}}</div>
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
                Homeに戻る
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
      <Adsense
        class="adsbygoogle my-2 box-shadow"
        style="display:block; min-width:250px"
        data-ad-client="ca-pub-9067426465896411"
        data-ad-slot="5078046569"
        data-ad-format="horizontal"
        data-full-width-responsive="true"
      >
      </Adsense>
    </div>
    <!-- about learn -->
    <div class="modal fade" id="learn-description" tabindex="-1" role="dialog" aria-hidden="true" >
      <div class="modal-dialog  " style="max-width:700px">
        <div class="rounded p-1 modal-content text-center" >
          <div class="text-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button><br>
          </div>
          <div style="display:inline-block">
              <img src="/image/learn-description1.webp" class="my-2" style="height:581px; width:300px" alt='スキマ時間にクリックするだけ 単語学習の使い方 1.最初はレベル1を選びましょう 2.STARTボタンを押しましょう'>
              <img src="/image/learn-description2.webp" class="my-2" style="height:581px; width:300px" alt='3.4択問題が出るので正解を選びましょう 4.記憶の定着度に応じて自己評価ボタンを選びましょう'>
              <img src="/image/learn-description3.webp" class="my-2" style="height:581px; width:300px" alt='5. 10問解くと結果が表示されるので、ざっと目を通しましょう 6.「学習状況を確認」を選びましょう'>
              <img src="/image/learn-description4.webp" class="my-2" style="height:581px; width:300px" alt='7.学習状況と復習予定が表示されます 8.自分のペースで次の学習に進みましょう'>
          </div>
          <div class="text-center">
            <button type="button" class="border border-2 border-muted text-muted  white rounded" data-dismiss="modal" aria-label="Close" style="width:100px; display:inline-block;">
              <span aria-hidden="true">Close</span>
            </button>
          </div>
        </div>
      </div>
    </div>      

  </div>
 
</template>

<script>
  import Choice from './Choice.vue'
  export default {
    name: 'Learn',
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
        baseColors:[" red lighten-4", " amber lighten-4", " lime lighten-4", " green lighten-4"],
        adsenseContent1: '',
        adsenseContent2: '',        
      }
    },

    mounted(){
      this.adsenseContent1 = document.getElementById('divadsensedisplaynone1').innerHTML;
      this.adsenseContent2 = document.getElementById('divadsensedisplaynone2').innerHTML;
    },    

    computed: {
      message: function () {
        if(this.status==="INITIAL"){
          return "";
        }else if(this.status==="LOADING"){
          return "";//"Now Loading";
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
      subscription: {
        type: String,
      },
      initial_level:{
        type: String,
      },
      time_limit:{
        type: String,
      },
      max_level:{
        type: String,
      },
      trial_level:{
        type: String,
      },
      guest_level:{
        type: String,
      },            
    },
    
    methods: {

      clickStart() { //学習開始のボタンをクリック
        console.log("START pressed");
        if(this.subscription === 'GUEST'){
          if(Number(this.level) <= Number(this.guest_level)){
            this.status = "WARN_RANDOM"
            return;
          }else{
            this.status = "RECOMMEND_TRIAL";
            return;
          }
        }else if(this.subscription === 'TRIAL'){
          if( Number(this.level) > Number(this.trial_level) && this.level !== 'REVIEW_ALL'){
            this.status = "RECOMMEND_NORMAL"
            return;
          }
        }
        this.load();
      },

      load() { //学習開始のボタンをクリック
        console.log("start LOADING");      
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
          params:{ 
            level: this.level,
            component: this.$options._componentTag,
            previous: this.answer_F,
          }
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