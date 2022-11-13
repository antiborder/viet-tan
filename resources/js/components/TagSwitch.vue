
<template>
    <div >
        <input type="checkbox" v-model="checked" />
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
      }
    },

    watch: {
      checked: function(val) {
        // this.update;
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

        }).catch(err => {
          console.log('err:', err);
          console.log('this.column');
          console.log('this.checked');                    
        });
      },
    }
  }
</script>