import './bootstrap'
import Vue from 'vue'
//==========ここから追加==========
import ArticleTagsInput from './components/ArticleTagsInput'
//==========ここまで追加==========

const app = new Vue({
  el: '#app',
  components: {
    //==========ここから追加==========
    ArticleTagsInput,
    //==========ここまで追加==========
  }
})