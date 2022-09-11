
<template>
  <div class="mx-auto text-center" style="max-width:700px;">
    <div class="normal-text mt-1 text-left">
      単語力測定　正解率: {{correct}} / {{total}}
    </div>

    <!-- 最初の画面 -->
    <div v-if="status==='INITIAL'" class="mx-auto text-center" style="max-width:400px">
      <div class="card white rounded" style="max-width: 400px;">
        <div class="card-body text-center">
          <div class="m-2 p-2" style="font-size:1.1rem">
            単語力を測定するために<br>
            11問出題されます。
          </div>
          <div class="mt-4 p-1">
            <button @click="clickStart()" type="button" class="btn btn-primary start-btn">
              START ▶
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

    <!-- 出題画面 -->
    <div v-if="status!=='RESULT'" class="mt-1 d-flex flex-row" style=" height: 55px;">
      <div v-bind:class="result_text_color" class="text-nowrap pt-1 text-left" style="width:20%; font-size: 1.0rem;">
        {{result_text}}
      </div>
      <div v-if="status==='JUDGED' || status==='ANSWERED' || status==='PROMPT' "class="card white rounded"  style="width:60%; display:table;">
        <span v-if="mode === 'FM'" class="h4 mt-1 bounce" style="vertical-align:middle; display:table-cell;">{{answer_F}}</span>
        <span v-if="mode === 'MF'" class="h5 mt-1 bounce" style="white-space: pre-line; vertical-align:middle; display:table-cell;">{{answer_M}}</span>
      </div>
    </div>
    <!-- 次へ進むボタン -->
    <div v-if=" status==='JUDGED'  || status==='ANSWERED' " class="mt-1 mb-1 text-left" style="max-width:500px; margin:auto">
      <span class = "text-center">
        <a @click="clickButton()" type="button" class="btn-primary next-btn text-white">
          次へ ▶
        </a>
      </span>
    </div>

    <!-- メッセージ -->
    <div v-if="status==='LOADING' " class="spinner-border text-muted " role="status" style="width: 3rem; height: 3rem;">
      <span class="sr-only">Loading...</span>
    </div>
    <div v-if="status==='LOADING' || status==='PROMPT' " class="pt-2 text-center" style="height: 60px;">
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
    <div v-if="status==='JUDGED' || status==='ANSWERED' || status==='PROMPT' " class="text-center">
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

    <!-- 結果表示 RESULT -->
    <div v-if="status==='RESULT' " class="card my-2 pb-1 white rounded mx-auto text-center" style="max-width:400px;">
      <div class="p-1 text-muted" style="font-size:1.2rem;"> 結果 </div>
      <div class="p-1">
        <p class="px-5 py-0 m-0 text-left" style="font-size:0.9rem;">{{result_message[0]}}</p>
        <p class="px-5 py-0 m-0 text-center" style="font-size:1.2rem;">{{result_message[1]}}</p>
        <p class="px-5 py-0 m-0 text-right" style="font-size:0.9rem;">{{result_message[2]}}</p>
      </div>
      <div v-if="level>0" class="p-1">おすすめレベル：　level {{level}}</div>
      <div class="text-center">
        <a v-bind:href="'/learn/' + level" class="btn primary-btn leave-measure-btn">
          レベル {{level}}を学習する
        </a>
        <a href="/" class="btn home-btn leave-measure-btn">
          Homeに戻る
        </a>
      </div>
    </div>

    <div v-if="status==='RESULT' ">
      <div class="card white rounded mt-4 mx-auto text-center" style="max-width:400px; font-size: 1.2 rem;">
        <div class="mb-2">
          <div class="text-muted" style="font-size:0.8rem">単語をクリックすると詳細ページが開きます。</div>
          <table class="result-table">
            <tr >
              <th></th>
              <th style="min-width:70%">単語</th>
              <th>level</th>
              <th>結果</th>
            </tr >
            <tr v-for="e in this.history">
              <td>{{e.No}}</td>
              <td style="font-size:1.3rem">
                <a v-bind:href="'/words/'+e.id" class="name-result viet-text" type="button" target="_blank" rel="noopener noreferrer">
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
                <div v-if= "e.result" class="text-top pb-2">
                  <i class="mt-2 text-success fas fa-check" style="font-size:190%;"></i>
                </div>
                <div v-else-if= "!e.result" class="text-top">
                  <span  class="m-0 p-0 text-danger" style="font-size:190%;"> ✖ </span>
                </div>
              </td>
            </tr>
          </table>
          <div class="px-2 text-right" >正解率： {{correct}}/{{total}}</div>
        </div>
      </div>
      <Adsense
        class="adsbygoogle my-2 box-shadow"
        style="display:block; min-width:250px"
        data-ad-client="ca-pub-9067426465896411"
        data-ad-slot="5078046569"
        data-ad-format="horizontal"
        data-full-width-responsive="false"
      >
      </Adsense>
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
        level: 0,
        total:0,
        correct:0,
        isCorrect: null,
        history:[],

        current_estimate: 0,
        test_levels:[],
        estimate_record:[],

      }
    },

    computed: {
      message: function () {
        if(this.status==="INITIAL"){
          return "";
        }else if(this.status==="LOADING"){
          return "";//"Now Loading";
        }else if(this.status==="PROMPT"){
          return "正解を選んでください";
        }else if(this.status==="JUDGED"){
          return "";
        }else if(this.status==="ANSWERED"){
          return "";
        }
      },
      result_message: function () {
        switch(Math.round(this.current_estimate)){
          case 0:
            return ['あなたの単語力はだいたい','0語～300語','くらいです。'];
          case 1:
            return ['あなたの単語力はだいたい','100語～500語','くらいです。'];
          case 2:
            return ['あなたの単語力はだいたい','300語～700語','くらいです。'];
          case 3:
            return ['あなたの単語力はだいたい','500語～1000語','くらいです。'];
          case 4:
            return ['あなたの単語力はだいたい','700語～1300語','くらいです。'];
          case 5:
            return ['あなたの単語力はだいたい','1000語～1600語','くらいです。'];
          case 6:
            return ['あなたの単語力はだいたい','1300語～2000語','くらいです。'];
          case 7:
            return ['あなたの単語力はだいたい','1600語～2500語','くらいです。'];
          case 8:
            return ['あなたの単語力はだいたい','2000語～3000語','くらいです。'];
          case 9:
            return ['あなたの単語力はだいたい','2500語～3500語','くらいです。'];
          case 10:
            return ['あなたの単語力はだいたい','3000語～4000語','くらいです。'];
          case 11:
            return ['あなたの単語力はだいたい','3500語～4500語','くらいです。'];
          case 12:
            return ['あなたの単語力はだいたい','4000語～5000語','くらいです。'];
          case 13:
          case 14:
            return ['あなたの単語力はたぶん', '4500語以上', 'です。'];
          default:
            return ['申し訳ありません。不具合により単語力が測定できないようです。', '', ''];
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

      time_limit:{
        type: String,
      },
      max_level:{
        type: String,
      },

    },

    methods: {

      clickStart() { //学習開始のボタンをクリック
        console.log("START pressed");
        this.setLevel();
        this.status = "LOADING";
        this.isCorrect = null;
        this.total = 0;
        this.history = [];
        this.correct = 0;
        this.load();
      },

      load() { //学習開始のボタンをクリック
        console.log("start LOADING");
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

      clickButton() { //次の単語に進むボタンをクリック
        this.sec = 0;
        this.history.push({'No':this.total, 'name':this.answer_F, 'result':this.isCorrect, 'level':this.answer_level, 'id':this.answer_id});
        this.setEstimateLevel();
        this.setLevel();
        this.isCorrect = null;
        if(this.total >= 11){
          this.status = "RESULT"
          this.level = Math.round(this.current_estimate)
          if(this.level <= 0){
            this.level = 1;
          }
          let result_sound = new Audio('/sound/result.mp3');
          result_sound.volume = 0.3;
          result_sound.play();
        }else{
          this.status = "LOADING";
          this.getWords();
        }
      },

      setEstimateLevel(){
        if(this.total === 1){
          let correct = this.history[0]['result'] ? 1 : 0;
          this.current_estimate = this.estimateFromOne( this.history[0]['level'], correct) - 1;//補正
        }else if(this.total ===3){
          this.updateEstimate(this.total);
        }else if(this.total ===5){
          this.updateEstimate(this.total);
        }else if(this.total ===7){
          this.updateEstimate(this.total);
        }else if(this.total ===9){
          this.updateEstimate(this.total);
        }else if(this.total ===11){
          this.updateEstimate(this.total);
        }
      },

      updateEstimate(index){
        let correct = (this.history[index-2]['result'] ? 1 : 0) + (this.history[index-1]['result'] ? 1 : 0);
        let estimate = this.estimateFromTwo( this.history[index-2]['level'], this.history[index-1]['level'], correct, (13-index)/2);
        this.estimate_record.push(estimate);
        this.current_estimate = this.average(this.estimate_record) - 1 ;//補正
      },

      setLevel(){
        if(this.total === 0){
          this.test_levels.push(this.trimLevel(Math.round(3 + Math.random()*5)));
        }else if(this.total === 1){
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate - (11-this.total)/2 + 1)));
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate + (11-this.total)/2 )));
        }else if(this.total === 3){
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate - (11-this.total)/2 + 1)));
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate + (11-this.total)/2)));
        }else if(this.total === 5){
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate - (11-this.total)/2 + 1)));
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate + (11-this.total)/2)));
        }else if(this.total === 7){
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate - (11-this.total)/2 + 1)));
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate + (11-this.total)/2)));
        }else if(this.total === 9){
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate - (11-this.total)/2 + 1)));
          this.test_levels.push(this.trimLevel(Math.round(this.current_estimate + (11-this.total)/2)));
        }
        this.level = this.test_levels[this.total]
      },

      trimLevel(l){
        if(l<1){
          return 1;
        }else if(l>14){
          return 14;
        }else{
          return l;
        }
      },

      estimateFromOne(level, correct){

        let low = (0 + level - 1)/2;
        let high = (level + 15 - 1)/2;
        if( correct === 0 ){
          return low;
        }else if(correct === 1){
          return (3*high + low)/4;
        }
      },

      estimateFromTwo(level1, level2, correct, range){
        let bottom = this.current_estimate - range;
        if (bottom < 0){
          bottom = 0;
        }
        let top = this.current_estimate + range;
        // if (top > 14){
        //   top = 14;
        // }

        if(level1 > level2){
          let tmp = level1;
          level1 = level2;
          level2 = tmp;
        }
        let low = (bottom + level1 - 1)/2;
        let mid = (level1 + level2 -1)/2;
        let high = (level2 + top - 1)/2;
        if( correct === 0 ){
          return low;
        }else if(correct === 1){
          return (3*mid + low)/4;
        }else if(correct === 2){
          return (mid + 3*high)/4;
        }
      },

      average(array){
        let sum = 0;
        array.forEach(function(v) {
          sum += v;
        });
        return sum / array.length;
      },

      async getWords() { //次の単語を取得
        const response = await axios.get(this.endpoint_to_get_word, {
          params:{
            level: this.level,
            component: this.$options._componentTag,
            previous: this.answer_F
          }
        });
        //本来はきれいなjsonで来てほしいが、dataの頭に全角スペースが入ることもあるため、どちらでもいいように場合分けしている。
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
        for(let i = (array.length - 1); 0 < i; i--){
          let r = Math.floor(Math.random() * (i + 1));
          let tmp = array[i];
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