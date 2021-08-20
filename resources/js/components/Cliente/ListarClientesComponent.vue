<template>
  <div>
    <div class="container-center">
      <v-card elevation="5">


      <!-- skeleton loading  -->
      <v-container v-if="loading_item">
        <v-skeleton-loader
          bind="attrs"
          type="list-item-avatar"
          :loading ="loading_item"
          v-if="loading_item"
        ></v-skeleton-loader>
      </v-container>

        <!-- Lista de alunos -->
        <v-banner icon="mdi-account" v-if="loading_item == false" single-line v-for="cliente in clientes"  :key="cliente.id">
          <v-toolbar-title class="text-subtitle-1">{{cliente.nome}} {{cliente.sobrenome}}</v-toolbar-title>
          <template v-slot:actions>
              <v-btn elevation="0" fab dark color="error" small class="text-decoration-none">
                <v-icon>
                  mdi-delete
                </v-icon>
              </v-btn>
          </template>
        </v-banner>

      </v-card>
    </div>
  </div>
</template>

<script>
  export default{
    data(){
      return{
        clientes:{},
        loading_item: true,
        attrs: {
          class: 'mb-6'
        },
      }

    },

    created(){
         this.axios
            .get('/api/cliente/')
            .then(response=>{
                this.clientes = response.data;
                this.loading_item = false;
            })
    },


  }
</script>

<style scoped>
 .container-center{
   max-width: 900px;
   width:100%;
   margin:60px auto;
 }
</style>
