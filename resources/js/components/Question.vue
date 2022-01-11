//ほかのページの表示を調整。
  //色、中央寄せ。意味の改行。考えてる間にデータロード。answerとothersを取得する部分を整理。
  //検索ボタンの色を透明に。ロード中も前の単語カードは見えてる。正解不正解に色をつける。
  //Ｎ+1問題。
  //questionじゃなくてapp.jsを使いたい。
//単語を読み上げる
// 発音類似語を出したい。


//代入には$setを使う。
//時間切れ status=timeout の実装。
//正解率
//レベル選定
//正解不正解の表示を左肩に。Answer単語の行とボタンの2行にする。

<template>
  <div>
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

    <div v-for="i in zeroToThree">
      <div v-if="status==='PROMPT' || status === 'ANSWERED'">
        <div class="d-flex flex-row mx-auto">
          <div style ="width:10%">
            <span v-if= "choices[i].pressed && choices[i].isAnswer" >
              <i class="mt-2 text-success fas fa-3x fa-check"></i>
            </span>
            <span v-else-if= "choices[i].pressed && !choices[i].isAnswer" >
              <span  class="m-0 p-0 text-danger" style="font-size:300%;"> ✖ </span>
            </span>
          </div>
          <div style="width:90%">
            <div @click="turnPressed(i)" class="card mt-0 mb-2 pt-1 pb-1 pl-3 pr-3 white rounded d-flex flex-row" style="height:90px; max-width: 30rem;">
              <div class = "h6" style ="width:40%">
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
        choices:[
        //   {
        //     isAnswer:null,
        //     pressed:false,
        //   },
        //   {
        //     isAnswer:null,
        //     pressed:false,
        //   },          
        //   {
        //     isAnswer:null,
        //     pressed:false,
        //   },          
        //   {
        //     isAnswer:null,
        //     pressed:false,
        //   },
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
          if(
            this.choices[0].pressed == this.choices[0].isAnswer &&
            this.choices[1].pressed == this.choices[1].isAnswer &&
            this.choices[2].pressed == this.choices[2].isAnswer &&
            this.choices[3].pressed == this.choices[3].isAnswer
          ){
            return "正解";
          }else{
            return "不正解";
          }
        }        
      }

    },

    props: {
      endpoint: {
        type: String,
      },
    },
    
    methods: {

      clickButton() {
        console.log(location.hostname);
        console.log("pressed");
        this.status = "LOADING";

        this.setRandom()
      },


      async setRandom() {
        const response = await axios.get(this.endpoint);
        let trimed = response.data.replace(/　+/g,'');
        let jsoned = JSON.parse(trimed);        
        // let answer = jsoned.answer;
        // answer = this.formatWord(answer);
               
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