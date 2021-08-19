<template>
  <div v-if="load_page == false">
    <p></p>
    <v-container class="d-flex justify-space-around flex-wrap">
        <v-card elevation="5" width="200" >
            <v-card-title class="text-h5">asdadas</v-card-title>
        </v-card>

        <v-card elevation="5" width="200">
          <v-card-title class="text-h5">asdasda</v-card-title>
        </v-card>

        <v-card elevation="5" width="200">
          <v-card-title class="text-h5">asdasd</v-card-title>
        </v-card>
    </v-container>
  </div>
</template>

<script>
  export default{
    data (){
      return{
        interval:{},
        load_page:true,
        value_1:80,
        value1:0,
      }
    },

    // created(){
    //   if (localStorage.getItem('token')!= null
    //     this.load_page = false
    // },


    mounted(){
      if (localStorage.getItem('token')!= null)
        this.load_page = false
    },
    // mounted(){
    //   this.interval = setInterval(() => {
    //    if (this.value1 === 80) {
    //      console.log(this.value1);
    //      clearInterval(this.interval)
    //    }
    //    else{
    //      this.value1 += 1
    //    }
    //  },200)
    // },
  }
</script>
