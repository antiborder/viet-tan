//googleログイン
//レベル別習熟度を常に隅っこに表示。
//学習履歴と学習予定をユーザーページに表示。
//*** 単語読み上げ
//ユーザ管理。権限レベル毎に管理。個人ページは本人と管理者しか見れないように。
//*** 課金システム
//単語毎の熟練度。などの表示をもっときれいに　単語内訳は0,1,2,3とunlearned。
//熟練度にtimeの影響も反映。
//level11でエラーが出る単語：紺色とスポンジ。意味が???になる単語：劇 この他に、詳細が出ない単語が結構ある。
//** 復習オンリーモード実装
//** 意味⇒単語の実装。
//エクスポート機能
//レベルをclearしたときに単語ロードで一回エラーが出る。二回同じ単語が続くときがある。前の単語を引数としてチェックしてるはずなのに、何故だ？
//前の単語を隅っこに表示。
//選択肢からanswerの類義語を取り除く
//ユーザー名は英数字のみに。
//レベル選定はゲージで。modalで。総復習モードも実装。
//toppageにはお知らせ。
//toppageにアプリ説明。
//url取得
//ssl認証
//Googleadsense
//テスト実装
//様々なパラメータを定数化。単語の音節数とか、タグ数とか、問題の選択肢の数だとか。
//Ｎ+1問題。
//学習完了メッセージとその後のrouteをもっと真面目にやる。おすすめレベルなど。
//ベトナム語検索結果を部分一致と全体一致に分ける。表示順序や表示数もちょうせい。
//学習単語がなくなった時の処理と、今日の学習完了の判定条件。とメッセージ。
//WordControllerのupdate、create、importの共通部分をまとめたい。
//時刻はどの場所の時刻になるのか、ぶれないように確認必要。
//代入には$setを使う。
//.emvのAPP_URLは最終的には製品版のURLを入れる。教材6-5「パスワード再設定メール(テキスト版)のテンプレートの作成」

<template>
  <div class="mx-auto" style="text-align:center; max-width:800px;">
    <div style="text-align:left">
      Lv.:{{level}}　正解率: {{correct}} / {{total}} {{status}} {{isCorrect}} {{recommendation}}{{user_name}}
    </div>
    <div v-if="status==='CLEARED'" class="card white rounded mt-5 mx-auto" style="width:200px">
      cleared!!
      <a v-bind:href="'/users/'+user_name">
        学習状況を確認
      </a>
    </div>    
    <div class="mt-1 d-flex flex-row" style=" height: 40px;">
      <div v-bind:class="result_text_color" class="text-nowrap pt-1" style="text-align:left;   width:20%; font-size: 1.0rem;  "> 
        {{result_text}}
      </div>
      <div v-if="status==='JUDGED' || status==='ANSWERED' || status==='PROMPT' "class="card white rounded"  style="width:60%">
        <span class="h4 mt-1 bounceIn">{{answer}}</span>
      </div>
    </div>

    <div v-if=" status==='ANSWERED' " class="mt-1 mb-1" style="text-align:left; max-width:650px">
      <span class="pt-2 text-nowrap;" style = "min-width:70px; text-align:left; font-size: 0.9rem;">
        覚えた？
      </span>      
      <span v-for="i in zeroToThree" style = " text-align:center;">
        <span v-if=" isCorrect===true || i===0">
          <button @click="clickButton(i)" type="button" v-bind:class="colors[i]" class="btn btn-info rounded pt-1 pb-1 px-2 text-nowrap"style="min-height:40px; max-width: 100px; font-size: 0.9em;">
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

    <div class="mx-auto" style="max-width:545px"> <!-- 選択肢の配列。別ファイルに分けたい。 -->
      <div v-for="i in zeroToThree">
        <div v-if="status==='PROMPT' || status === 'JUDGED' || status ==='ANSWERED'" class="" >
          <div class="d-flex flex-row" >
            <div style ="width:7%">
              <span v-if= "choices[i].pressed && choices[i].isAnswer" class="bounceIn">
                <i class="mt-2 text-success fas fa-2x fa-check"></i>
              </span>
              <span v-else-if= "choices[i].pressed && !choices[i].isAnswer" >
                <span  class="m-0 p-0 text-danger" style="font-size:200%;"> ✖ </span>
              </span>
            </div>
            <div style="width:93%">
              <div @click="turnPressed(i)" v-bind:class="cardColor(i)" class="card mt-0 mb-2 pt-1 pb-1 pl-3 pr-3 rounded d-flex flex-row" style="min-height:90px; max-width: 500px;">
                <div class = "h6" style ="width:40%; white-space: pre-line; text-align:left">
                  <div v-if="sec >= 1">
                    {{choices[i].word.jp}}
                  </div>
                </div>                          
                <div class = "border-left border-light pl-2" style ="width:60%">
                  <div v-if="choices[i].pressed">
                    <div class="d-flex flex-row">
                      <div v-for="j in zeroToSeven">
                        <div class="h5 card-title mr-2 mb-0">
                          {{ choices[i].word.syllables[j] }}
                        </div>
                        <div class="px-auto pr-2 mt-0 text-muted" style="font-size:1.3em" >
                          {{ choices[i].word.kanjis[j] }}
                        </div>
                      </div>
                      <a v-bind:href="'/words/'+choices[i].word.id" target="_blank" rel="noopener noreferrer" class="text-info mr-2" style="margin:0 0 0 auto">
                        詳細
                      </a>                  
                    </div>
                    <div class="d-flex align-items-end">
                      Lv.{{ choices[i].word.level }}
                    </div>
                  </div>
                  <div v-else class="" style="text-align:center">
                    <i class="mt-3 text-muted fas fa-3x fa-question "></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="status==='JUDGED' || status==='ANSWERED' || status==='PROMPT' " style="text-align:center">
      {{sec}}
    </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        rootURL:location.hostname,
        zeroToThree:[0,1,2,3],
        zeroToSeven:[0,1,2,3,4,5,6,7],
        answer:" ",
        status : "INITIAL",
        initialChoice: null,
        sec: 0,
        timerOn: false, 
        timerObj: null,
        choices:[],
        level:1,
        total:0,
        correct:0,
        isCorrect: null,
        button_properties:[
          { text:"いいえ"},
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
        const baseColors = ["pink", "red", "deep-orange", "orange"];
        let colors = [];
        for(let i=0;i<=3;i++){
          if(i === this.recommendation){
            colors.push(baseColors[i]+" lighten-2 animated bounceIn ");
          }else{
            colors.push("grey"+" lighten-1");
          }
        }
      return colors;
      },
    },

    watch: {
      status: function(val) { //一つ目を選択した瞬間に正誤が決まり、その後は変わらないようにしている。

        if( (val==="JUDGED" || val==="ANSWERED") && this.isCorrect === null){
          this.stopTimer();
          if(
            this.choices[0].pressed == this.choices[0].isAnswer &&
            this.choices[1].pressed == this.choices[1].isAnswer &&
            this.choices[2].pressed == this.choices[2].isAnswer &&
            this.choices[3].pressed == this.choices[3].isAnswer
          ){
            this.isCorrect = true;
            this.correct += 1;
            this.total += 1;            
          }else{
            this.isCorrect = false;
            this.total += 1;
          }
        }else if(val==="LOADING"){
          this.isCorrect = null;
          this.initialChoice = null;
        }
      },

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
    },
    
    methods: {

      clickStart() { //学習開始のボタンをクリック
        console.log("START pressed");
        this.status = "LOADING";        
        this.getWords();        
      },

      clickButton(n) { //次の単語に進むボタンをクリック
        this.sec = 0;        
        this.recordLearn(n);
        this.status = "LOADING";        
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
            'pressed':false,
          }
        }
        this.choices[3] = {
          'word':this.formatWord(jsoned.answer), 
          'isAnswer':true,
          'pressed':false
        }        

        this.answer = this.formatWord(jsoned.answer).syllables.join(" ");
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
        this.$set(this.choices[n],'pressed', true)
        if(this.status == "PROMPT"){
          this.status = "JUDGED";
          this.initialChoice = n;  
        }      
        if(this.choices[n].isAnswer){
          this.status = "ANSWERED"
        }
        this.choices.splice(); //配列の変更を反映するためにこの一行が必要。

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

      cardColor(i){

          if(this.initialChoice === i){
            if(this.choices[i].isAnswer === true){
              return "green lighten-5";
            }else if (this.choices[i].isAnswer === false){
              return "red lighten-5";
            }
          }else{
            return "white";
          }

      },
    },  
    
  }
</script>