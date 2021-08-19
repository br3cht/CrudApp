<template>
  <div>
    <v-navigation-drawer absolute permanent left class="light-blue accent-4" width="350">

      <v-list dark>
      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="text-h4">
            CrudApp
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
    <v-divider></v-divider>

    <v-container>
      <v-form ref="form" v-model="valid" lazy-validation>
        <v-text-field
          v-model="user.email"
          :rules = "EmailRules"
          label="Email"
          required
          solo
          :error-messages="erros.email"
        ></v-text-field>

        <v-text-field
          v-model="user.password"
          :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
          :rules="PasswordRules"
          :type="show1 ? 'text' : 'password'"
          label="Senha"
          solo
          @click:append="show1 = !show1"
          required
        ></v-text-field>


        <v-alert :value="alert" type="error" transition="scale-transition" colored-border  border="left" >Email ou Senha Incorretos</v-alert>

        <div class="text-right">
             <v-btn dark rounded block :disable="!valid" color="primary" class="mr-4" @click="validate">login</v-btn>
           </div>
      </v-form>
    </v-container>

    </v-navigation-drawer>
  </div>
</template>

<script>
  export default{
    data(){
      return{
        user:{
         device_name: 'browser',
         alert:false
       },
       valid:true,
       alert:false,
       show1: false,
       msg_errors:{},
       erros:{
         email:'',
       },
       PasswordRules:[
         v => !!v || 'Preenchimento Necessario',
         v => (v && v.length <= 8) || 'Ultrapssou o Limite',
       ],
       EmailRules:[
         v => !!v || 'Preenchimento Necessario',
         v => /.+@.+\..+/.test(v) || 'E-mail Não Valido',
       ],
      }
    },
    methods:{
      login(){
        axios.post('api/auth/login', this.user)
          .then((response) =>{
              if(response.data.status  == 'sucess'){
                localStorage.setItem('token', response.data.token)
                this.$router.go(this.$router.currentRoute)
              }
              else{
                this.alert = true
                this.msg_errors = response.data.msg
                this.openAlert()

              }
           })
           // .catch((errors)=>{
           //     this.errors = errors.response
           //     console.log(this.errors);
           // })
      },

      openAlert(){
        this.alert = true
        setTimeout(() => {this.alert = false}, 2000)
      },

      validate(){
        if(this.$refs.form.validate()){
          this.login();
        }
      },
    },
  }
</script>
