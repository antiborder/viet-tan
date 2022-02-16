//レベルが入力されてないデータはアップロード直後に削除する。
//スマホでも見える漢字フォントに。
//カードの見栄えをもう少しきれいに
//git ログインでのパスワード入力を省略
//テスト実装
//レベル選定はゲージで。modalで。
//単語読み上げ
//学習完了の判定条件。
//ユーザーページ表示
//レベル別習熟度を常に隅っこに表示。
//様々なパラメータを定数化。単語の音節数とか、タグ数とか、問題の選択肢の数だとか。
//Ｎ+1問題。
//いつも出ているvueのエラーを修正。
//ベトナム語検索結果を部分一致と全体一致に分ける。表示順序や表示数もちょうせい。
//学習単語がなくなった時の処理と、今日の学習完了の判定条件。とメッセージ。
//考えてる間にデータロード。
//WordControllerのupdate、create、importの共通部分をまとめたい。
//クリックしてほしい箇所をテカらせる。
//時間切れ status=timeout の実装。
//時刻はどの場所の時刻になるのか、ぶれないように確認必要。
//代入には$setを使う。


<template>
  <div class="mx-auto" style="text-align:center; max-width:800px;">
    <div style="text-align:left">
      Lv.:{{level}}　正解率: {{correct}} / {{total}}
    </div>
    <div class="mt-1 d-flex flex-row" style=" height: 40px;">
      <div v-bind:class="result_text_color" class="text-nowrap pt-1" style="text-align:left;   width:20%; font-size: 1.0rem; font-weight: ; "> 
        {{result_text}}
      </div>
      <div v-if="status==='ANSWERED' || status==='PROMPT' "class="card white rounded"  style="width:60%">
        <!--   "class=" mx-auto "  -->
        <span class="h4 mt-1">{{answer}}</span>
      </div>
    </div>

    <div v-if=" status==='ANSWERED' " class="mt-1 mb-1" style="text-align:left; max-width:650px">
      <span class="pt-2 text-nowrap;" style = "min-width:70px; text-align:left; font-size: 0.9rem;">
        覚えた？
      </span>      
      <span v-for="i in zeroToThree" style = " text-align:center;">
        <span v-if=" isCorrect===true || i===0">
          <button @click="clickButton(i)" type="button" v-bind:class="button_properties[i].color" class="btn btn-info rounded pt-1 pb-1 px-2 btn-sm text-nowrap"style="min-height:40px; max-width: 100px; font-size: 0.9em;">
            {{button_properties[i].text}}
          </button>
        </span>
      </span>
    </div>    

    <div v-if="status==='PROMPT' || status==='LOADING'" class="pt-2" style=" text-align:center; height: 55px;">
      <span>
        {{message}}
      </span>
    </div>
    <div v-if="status==='INITIAL'" style=" text-align:center;">
      <input v-model="level" placeholder="Choose level">
      <div class="" style = "text-align:center; height: 80px;">
        <button @click="clickStart()" type="button" class="btn btn-info orange m-5 lighten-1 rounded pb-1 btn-sm text-nowrap"style="max-width: 240px; font-size: 1.6rem;">
          START
        </button>
      </div>
    </div>      

    <div class="mx-auto" style="max-width:545px"> <!-- 選択肢の配列。別ファイルに分けたい。 -->
    <div v-for="i in zeroToThree">
      <div v-if="status==='PROMPT' || status === 'ANSWERED'" class="" >
        <div class="d-flex flex-row" >
          <div style ="width:7%">
            <span v-if= "choices[i].pressed && choices[i].isAnswer" >
              <i class="mt-2 text-success fas fa-2x fa-check"></i>
            </span>
            <span v-else-if= "choices[i].pressed && !choices[i].isAnswer" >
              <span  class="m-0 p-0 text-danger" style="font-size:200%;"> ✖ </span>
            </span>
          </div>
          <div style="width:93%">
            <div @click="turnPressed(i)" class="card mt-0 mb-2 pt-1 pb-1 pl-3 pr-3 white rounded d-flex flex-row" style="min-height:90px; max-width: 500px;">
              <div class = "h6" style ="width:40%; white-space: pre-line; text-align:left">
                {{choices[i].word.jp}}
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
                    <a v-bind:href="'/words/'+choices[i].word.id" target=”_blank” class="text-info mr-2" style="margin:0 0 0 auto">
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
        choices:[],
        // input:"1",
        level:1,
        total:0,
        correct:0,
        isCorrect: null,
        button_properties:[
          { text:"いいえ"  , color:"pink lighten-2" },
          { text:"ぎりぎり..."  , color: "red lighten-2" },
          { text:"覚えた!"  , color: "deep-orange lighten-2" },
          { text:"余裕♪"  , color: "orange lighten-2" },
        ]
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
        }else if(this.status==="ANSWERED"){
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
        }else if(this.status==="ANSWERED"){
          return "";
        }        
      },
      result_text: function(){
        if(this.isCorrect == true){
          return "正解";
        }else if(this.isCorrect == false){
          return "不正解";
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
    },

    watch: {
      status: function(val) { //一つ目を選択した瞬間に正誤が決まり、その後は変わらないようにしている。
        if(val=="ANSWERED"){
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
        }else{
          this.isCorrect = null;
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
    },
    
    methods: {

      clickStart() { //学習開始のボタンをクリック
        console.log("START pressed");
        this.status = "LOADING";        
        this.getWords();        
      },

      clickButton(n) { //次の単語に進むボタンをクリック
        console.log("pressed");


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
        }).catch(err => {
          console.log('err:', err);
        });        
        console.log(response);
      },
      
      async getWords() { //次の単語を取得
        const response = await axios.get(this.endpoint_to_get_word, {
          params:{ level: this.level,
                    previous: this.answer }
        });
        //本来はきれいなjsonできてほしいが、dataの頭に全角スペースが入ることもあるため、どちらでもいいように場合分けしている。
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
        console.log(this.choices[n].pressed)
        this.status = "ANSWERED";
        this.choices.splice(); //配列の変更を反映するためにこの一行が必要。

      }
    },  
    
  }
</script>