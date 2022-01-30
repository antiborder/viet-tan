
//正解不正解に色をつける。
//正解不正解の表示を左肩に。Answer単語の行とボタンの2行にする。
//NEXTのボタンを三種類に。
//Ｎ+1問題。
//いつも出ているvueのエラーを修正。
//レベル選定はゲージで。modalで。
//単語読み上げ
//各ページの色を修正・統一。
//ユーザーレベルや履歴を元に単語選定
//正解率表示
//ユーザーページ表示
//考えてる間にデータロード。
//WordControllerのupdate、create、importの共通部分をまとめたい。

//代入には$setを使う。
//時間切れ status=timeout の実装。


<template>
  <div>
    {{status}}
    <div class="mt-5" style="text-align:center; height: 50px;">
      <span v-if="status==='ANSWERED' || status==='PROMPT'  "class="card mx-auto white rounded w-50" >
        <span class="h4">{{answer}}</span>
      </span>
    </div>
    <div style="text-align:center; height: 50px;">
      <button v-if=" status==='INITIAL' || status==='ANSWERED' "
        @click="clickButton" 
        type="button"
        class="btn btn-info blue-gradient pt-1 pb-1 btn-sm" style="font-size: large;"
      >
        {{buttonText}}
      </button>
    </div>
    <div style=" text-align:center; height: 50px;">
      <span>
        {{message}}
      </span>
    </div>
    <div v-if="status==='INITIAL'" style=" text-align:center;">
      <input v-model="level" placeholder="edit me">
      <p>input is: {{ level }}</p>
    </div>

    <div class="mx-auto border-secondary" style="width:545px">
    <div v-for="i in zeroToThree">
      <div v-if="status==='PROMPT' || status === 'ANSWERED'" class="border-primary" >
        <div class="d-flex flex-row" >
          <div style ="width:10%">
            <span v-if= "choices[i].pressed && choices[i].isAnswer" >
              <i class="mt-2 text-success fas fa-3x fa-check"></i>
            </span>
            <span v-else-if= "choices[i].pressed && !choices[i].isAnswer" >
              <span  class="m-0 p-0 text-danger" style="font-size:300%;"> ✖ </span>
            </span>
          </div>
          <div style="width:90%">
            <div @click="turnPressed(i)" class="card mt-0 mb-2 pt-1 pb-1 pl-3 pr-3 white rounded d-flex flex-row" style="height:90px; max-width: 500px;">
              <div class = "h6" style ="width:40%; white-space: pre-line;">
                {{choices[i].word.jp}}
              </div>                          
              <div class = "border-left border-light pl-2" style ="width:60%">
                <div v-if="choices[i].pressed">
                  <div class="d-flex flex-row">
                    <div v-for="j in zeroToSeven">
                      <div class="h5 card-title mr-2">
                        {{ choices[i].word.syllables[j] }}
                      </div>
                      <div class="px-auto" >
                        {{ choices[i].word.kanjis[j] }}
                      </div>
                    </div>
                    <a v-bind:href="'/words/'+choices[i].word.id" class="text-info mr-2" style="margin:0 0 0 auto">
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
        input:"1",
        level:"1",
        isCorrect: null,
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
          if(this.isCorrect == true){
            return "正解";
          }else{
            return "不正解"
          }
        }        
      }
    },

    watch: {
      status: function(val) {
        if(val=="ANSWERED"){
          if(
            this.choices[0].pressed == this.choices[0].isAnswer &&
            this.choices[1].pressed == this.choices[1].isAnswer &&
            this.choices[2].pressed == this.choices[2].isAnswer &&
            this.choices[3].pressed == this.choices[3].isAnswer
          ){
            this.isCorrect = true;
          }else{
            this.isCorrect = false;
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

      clickButton() {
        console.log(location.hostname);
        console.log("pressed");


        this.recordLearn();
        this.status = "LOADING";        
        console.log("recorded");
        this.setRandom();
      },

      async recordLearn() {
        console.log(this.status);
        console.log(this.isCorrect);
        console.log(this.answer);
        const response = await axios.post(this.endpoint_to_record_learn,
        {
          name: this.answer,
          result: this.isCorrect, 
          easiness: 3,
        }
        ).then(response => {
          console.log('status:', response.status); // 200
        }).catch(err => {
          console.log('err:', err);
        });        
        console.log(response);
      },
      
      async setRandom() {
        const response = await axios.get(this.endpoint_to_get_word, {
          params:{ level: this.level }
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


      arrayShuffle(array) {
        for(var i = (array.length - 1); 0 < i; i--){
          var r = Math.floor(Math.random() * (i + 1));
          // 要素の並び替えを実行
          var tmp = array[i];
          array[i] = array[r];
          array[r] = tmp;
        }
        return array;
      },
      
      turnPressed(n){
        this.$set(this.choices[n],'pressed', true)
        console.log(this.choices[n].pressed)
        this.status = "ANSWERED";
        this.choices.splice();

      }
    },  
    
  }
</script>