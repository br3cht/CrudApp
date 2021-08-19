<template>
  <div>
    <p></p>
    <p></p>
    <p></p>
    <v-container class="d-flex justify-center">
      <v-alert :value="alert" type="success" transition="scale-transition" colored-border  border="left" >Usuario Cadastrado Com Sucesso</v-alert>
      <v-card elevation="5" width="500" fill-height>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-container>
            <v-text-field
              v-model="user.name"
              :rules="nameRules"
              label="Nome"
              outlined
              required
            ></v-text-field>
            <v-text-field
              v-model="user.email"
              :rules = "EmailRules"
              label="Email"
              outlined
              required
            ></v-text-field>

            <v-text-field
              v-model="user.password"
              :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="PasswordRules"
              :type="show1 ? 'text' : 'password'"
              label="Senha"
              outlined
              @click:append="show1 = !show1"
              required
            ></v-text-field>


            <v-text-field
              v-model="user.password_confirmation"
              :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="PasswordRules"
              :type="show2 ? 'text' : 'password'"
              label="Confirmar a Senha"
              outlined
              @click:append="show2 = !show2"
              required
            ></v-text-field>


            <v-switch
              label="é super Usario"
              v-model="user.is_super_user"
            ></v-switch>

            <div class="text-right">
              <v-btn fab dark small :disable="!valid" color="primary" class="mr-4" @click="validate">
                   <v-icon>mdi-check</v-icon>
              </v-btn>
            </div>

          </v-container>
        </v-form>
      </v-card>
    </v-container>
  </div>
</template>

<script>
  export default{
    data(){
      return{
        user:{
          is_super_user:false
        },
        valid:true,
        show1: false,
        show2:false,
        switch1:false,
        alert:false,
        msg_errors:{},
        erros:{
          email:'',
        },
        PasswordRules:[
          v => !!v || 'Preenchimento Necessario',
          v => (v && v.length <= 8) || 'Ultrapssou o Limite',
        ],
        nameRules:[
         v => !!v || 'Preenchimento Necessario',
         v => (v && v.length <= 10) || 'Ultrapssou o Limite',
        ],
        EmailRules:[
          v => !!v || 'Preenchimento Necessario',
          v => /.+@.+\..+/.test(v) || 'E-mail Não Valido',
        ],
      }
    },
    methods:{
      register(){
        axios.post('api/auth/register', this.user)
          .then((response) =>{
            console.log(response.data);
            this.user = {}
            this.alert = true
            setTimeout(() => {this.alert = false}, 2000)
           })
           .catch((errors)=>{
               this.errors = errors.response
               console.log(this.errors);
           })
      },
      validate(){
        if(this.$refs.form.validate()){
          this.register()
        }
      },
    },
  }
</script>
