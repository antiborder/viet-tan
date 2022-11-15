
<template>
    <div >
        <input class="pl-5 pr-5" type="checkbox" v-model="checked" />
          　{{message}}
    </div>
</template>

<script>

  export default {
    name: 'TagSwitch',

    props: {

      initial_check: {
        type: String,
      },
      column: {
        type: String,
      },
      endpoint_to_update_check:{
        type: String,
      },

    },


    data(){
      return {
        checked: JSON.parse(this.initial_check),
        status: "INITIAL",
        click_count : 0,
      }
    },

    computed: {
      message : function () {
        if(this.status === "INITIAL"){
          if(this.initial_check==="true"){
            return "除外する";
          }else if(this.initial_check==="false"){
            return "除外しない";
          }else{
            return "エラー";
          }
        }else{
          if(this.status==="ON"){
            return "除外する";
          }else if(this.status==="OFF"){
            return "除外しない";
          }else{
            return "エラー";
          }
        }
      },
    },

    watch: {
      checked: function(val) {
        this.click_count++;
        this.updateCheck();
      },
    },
    
    methods:{
      async updateCheck() { //学習を記録
        const response = await axios.post(this.endpoint_to_update_check,
          {
            column: this.column,
            checked: this.checked,
          }
        ).then(response => {
          console.log('status:', response.status); // 200
          console.log('data:', response.data); //
          console.log('response:', response); //
          if(response.data['status'] === true){
            this.status = 'ON';  
          }else if(response.data['status'] === false){
            this.status = 'OFF';  
          }          

        }).catch(err => {
          console.log('err:', err);
          alert(err)
          this.status = 'エラー'
        });
      },
    }

  }
</script>