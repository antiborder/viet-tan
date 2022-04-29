

<template>
    <div class="d-flex flex-row" >
        <div style ="width:7%">
            <span v-if= "isPressed && isAnswer" class="bounceIn">
                <i class="mt-2 text-success fas fa-2x fa-check"></i>
            </span>
            <span v-else-if= "isPressed && !isAnswer" >
                <span  class="m-0 p-0 text-danger" style="font-size:200%;"> ✖ </span>
            </span>
        </div>
        <div style="width:93%">
            <div v-if="mode==='FM'">
                <div @click="turnPressed()" :class="cardColor()" class="card mt-0 mb-2 pt-1 pb-1 pl-2 pr-2 rounded d-flex flex-row" style="min-height:90px; max-width: 500px;"> 
                    <div class = "h6 ml-0" style ="width:40%; white-space: pre-line; text-align:left">
                        <div>
                            <div v-if="sec >= 1">
                                {{word.jp}}
                            </div>
                        </div>
                    </div>                          
                    <div class = "border-left border-light pl-2" style ="width:60%">
                        <div v-if="isPressed">
                            <div class="d-flex flex-row">
                                <div v-for="j in 8">
                                    <div v-if="isPressed" class="h4 card-title mr-2 mb-0">
                                        <div v-if="sec >= 1">
                                            {{ word.syllables[j-1] }}
                                        </div>
                                    </div>
                                    <div v-if="isPressed" class="px-auto pr-2 mt-0 text-muted" style="font-size:1.3em" >
                                    {{ word.kanjis[j-1] }}
                                    </div>
                                </div>
                                <a v-if="isPressed" v-bind:href="'/words/'+word.id" target="_blank" rel="noopener noreferrer" class="text-info mr-2" style="margin:0 0 0 auto">
                                    詳細
                                </a>                  
                            </div>
                            <div v-if="isPressed" class="d-flex align-items-end">
                            Lv.{{ word.level }}
                            </div>
                        </div>
                        <div v-else class="" style="text-align:center">
                            <i class="mt-3 text-muted fas fa-3x fa-question "></i>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="mode==='MF'">
                <div @click="turnPressed()" :class="cardColor()" class="card mt-0 mb-2 pt-1 pb-1 pl-2 pr-2 rounded d-flex flex-row" style="min-height:90px; max-width: 500px;"> 
                    <div class = "ml-0 pl-0" style ="width:60%">
                        <div>
                            <div class="d-flex flex-row">
                                <div v-for="j in 8">
                                    <div  class="h4 card-title mr-2 mb-0">
                                        <div v-if="sec >= 1">
                                            {{ word.syllables[j-1] }}
                                        </div>
                                    </div>
                                    <div v-if="isPressed" class="px-auto pr-2 mt-0 text-muted" style="font-size:1.3em" >
                                    {{ word.kanjis[j-1] }}
                                    </div>
                                </div>
                                <a v-if="isPressed" v-bind:href="'/words/'+word.id" target="_blank" rel="noopener noreferrer" class="text-info mr-2" style="margin:0 0 0 auto">
                                    詳細
                                </a>                  
                            </div>
                            <div v-if="isPressed" class="d-flex align-items-end">
                            Lv.{{ word.level }}
                            </div>
                        </div>
                    </div>
                    <div class = "h6 pl-2 border-left border-light" style ="width:40%; white-space: pre-line; text-align:left">
                        <div v-if="isPressed" >
                            <div v-if="sec >= 1">
                                {{word.jp}}
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
</template>

<script>
export default {
    name:'Choice',
    props:{
        'mode':{
            type: String,
            default: "FM",
        },
        'word':Object,
        'isAnswer':{
            type: Boolean,
            default: false,
        },
        'status':{
            type: String,
            deault: "INITIAL",
        },
        'sec':{
            type: Number,
            default: 0,
        },
    },

    data(){
      return {
        zeroToSeven:[0,1,2,3,4,5,6,7],
        isPressed: false,
        isFirstChoice:false,
      }
    },

    methods:{
        turnPressed(){  //選択肢がクリックされた時のアクション
            if(this.status === "PROMPT" || this.status === "JUDGED"){
                if( !this.isPressed){
                    if(this.isAnswer === true){
                        let correct_sound = new Audio('/sound/correct1.mp3');
                        correct_sound.volume = 0.1;
                        correct_sound.play();
                        if(this.mode === "MF"){
                            let question_voice = new Audio('/sound/word/' + this.word.id + '.mp3');
                            question_voice.volume = 1.0;
                            question_voice.play(); 
                        }                       

                    }else{
                        let wrong_sound = new Audio('/sound/wrong1.mp3');
                        wrong_sound.volume = 0.3;
                        wrong_sound.play();
                    }
                }
            }
            this.isPressed = true
            if(this.status === "PROMPT"){
                this.isFirstChoice = true
            }
            this.$emit('pressed')            
        },

        cardColor(){
            if(this.isFirstChoice){
                if(this.isPressed === true){
                    if(this.isAnswer === true){
                        return "green lighten-5";
                    }else if (this.isAnswer === false){
                        return "red lighten-5";
                    }
                }
            }

        },        
    },
}
</script>