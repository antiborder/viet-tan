//ユーザーレベルや履歴を元に単語選定

//Ｎ+1問題。
//いつも出ているvueのエラーを修正。
//レベル選定はゲージで。modalで。
//単語読み上げ
//各ページの色を修正・統一。
//ユーザーページ表示
//考えてる間にデータロード。
//WordControllerのupdate、create、importの共通部分をまとめたい。
//クリックしてほしい箇所をテカらせる。
//時間切れ status=timeout の実装。
//レベル別習熟度を常に隅っこに表示。

//代入には$setを使う。


<template>
  <div>
    <div>
      Lv.:{{level}}　正解率: {{correct}} / {{total}}
    </div>
    <div class="mt-5" style="text-align:center; height: 55px;">
      <span v-if="status==='ANSWERED' || status==='PROMPT'  "class="card mx-auto white rounded w-50" >
        <span class="h4">{{answer}}</span>
      </span>
    </div>
    <div v-if=" status==='ANSWERED' "  style="text-align:center">
      <span class="pt-2 text-nowrap;" v-bind:class="result_text_color" style = "min-width:70px; text-align:center;">
        {{result_text}}
      </span>
      <span v-for="i in zeroToThree" style = " text-align:center;">
        <span v-if=" isCorrect===true || i===0">
          <button @click="clickButton(i)" type="button" v-bind:class="button_properties[i].color" class="btn btn-info rounded pt-1 pb-1 btn-sm text-nowrap"style="min-height:40px; max-width: 120px; font-size: 1rem;">
            {{button_properties[i].text}}
          </button>
        </span>
      </span>
    </div>    
    <!-- <div v-if=" status==='ANSWERED' " class="d-flex flex-row mx-auto " style=" height: 55px;">
      <div class="pt-2 text-nowrap;" v-bind:class="result_text_color" style = "min-width:70px; text-align:center;">
        {{result_text}}
      </div>
      <div v-for="i in zeroToThree" style = " text-align:center;">
        <div v-if=" isCorrect===true || i===0">
          <button @click="clickButton(i)" type="button" v-bind:class="button_properties[i].color" class="btn btn-info rounded pt-1 pb-1 btn-sm text-nowrap"style="min-height:40px; max-width: 120px; font-size: 1rem;">
            {{button_properties[i].text}}
          </button>
        </div>
      </div>
      
    </div> -->
    <div v-if="status==='PROMPT' || status==='LOADING'" style=" text-align:center; height: 55px;">
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

    <div class="mx-auto" style="width:545px">
    <div v-for="i in zeroToThree">
      <div v-if="status==='PROMPT' || status === 'ANSWERED'" class="" >
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
          { text:"まだまだ"  , color:"pink lighten-2" },
          { text:"難しい…"  , color: "red lighten-2" },
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
      status: function(val) {
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

      clickStart() {
        console.log("START pressed");
        this.status = "LOADING";        
        this.setRandom();        
      },

      clickButton(n) {
        console.log("pressed");


        this.recordLearn(n);
        this.status = "LOADING";        
        this.setRandom();
      },

      async recordLearn(n) {
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