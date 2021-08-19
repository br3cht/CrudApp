<template>
  <v-app>
    <div v-if="this.autenticaded" >
        <!-- Barra de superior -->
        <v-app-bar dense flat class="light-blue accent-4" dark>
           <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
           <v-toolbar-title>Rsus</v-toolbar-title>
           <v-spacer></v-spacer>

           <v-menu left bottom>
             <template v-slot:activator="{on, attrs}">
                <v-btn icon v-bind="attrs" v-on="on">
                  <v-icon> mdi-dots-vertical</v-icon>
                </v-btn>
             </template>

             <v-list>
               <v-list-item link class="text-decoration-none" :to="{name:'ListarUsuarios'}"v-if="currentUser.is_super_user">
                 <v-list-item-subtitle>Usuarios</v-list-item-subtitle>
                 <v-list-item-icon>
                   <v-icon>mdi-account-box</v-icon>
                 </v-list-item-icon>
               </v-list-item>
             </v-list>
           </v-menu>
        </v-app-bar>



        <!-- side Bar -->
        <v-navigation-drawer v-model="drawer" absolute temporary class="light-blue accent-4" dark>
          <v-list>

          <v-list-item link>
            <v-list-item-content>
              <v-list-item-title class="text-h6">
                {{currentUser.name}}
              </v-list-item-title>
              <v-list-item-subtitle>{{currentUser.email}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        <v-divider></v-divider>

          <v-list>
            <v-list-item link :to="{name:'home'}">

                <v-list-item-icon>
                  <v-icon> mdi-atom </v-icon>
                </v-list-item-icon>

                <v-list-item-title>Home</v-list-item-title>
            </v-list-item>

            <v-list-item link :to="{name:'CadastroCliente'}">
              <v-list-item-icon>
                <v-icon>mdi-file-chart</v-icon>
              </v-list-item-icon>

              <v-list-item-title>Cadastro de Clientes</v-list-item-title>
            </v-list-item>
          </v-list>


          <v-divider></v-divider>

          <div class="text-right">
               <v-btn dark rounded block color="primary" class="mr-4" @click="logout">logout</v-btn>
          </div>

        </v-navigation-drawer>
      <router-view></router-view>
    </div>
  </v-app>
</template>

<script>
export default {
  data(){
    return{
      drawer:null,
      currentUser:'',
      autenticaded:false
    }
  },

  created(){
          if (localStorage.getItem('token')!= null){
            var token = localStorage.getItem('token')
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            axios.get('api/auth/user').then(response =>{
                this.autenticaded = true
                this.currentUser = response.data
            }).catch((errors) =>{
                this.autenticaded = false
                localStorage.removeItem('token')
                this.$router.go(this.$router.push('/login'))
            })
          }
    },

  methods:{
      logout(){
        this.axios
          .post('api/auth/logout')
          .then(response =>{
            localStorage.removeItem('token')
            this.currentUser = {}
            this.autenticaded = false
            this.$router.go(this.$router.currentRoute)
          })
          .catch((errors) => {
              console.log(errors)
          })
      },
    }

}
</script>

<style>

@import url('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500');
*{
 padding: 0;
 margin: 0;
 list-style: none;
 text-decoration: none;
 font-family: 'Roboto', sans-serif;
}
</style>
