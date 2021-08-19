<template>
  <div class="container-center">
  <v-container>
    <v-row>
      <v-col cols="12" md="4">
        <v-card>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-subtitle>Total de Usuarios</v-list-item-subtitle>
              <v-list-item-title class="text-h5">{{users.length}}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
  <p></p>
  <v-alert :value="alert" type="success" border="top" colored-border elevation="2">Usuario Cadastrado com Sucesso</v-alert>
  <v-data-table
      :headers="headers"
      :items="users"
      :loading="loading_data"
      hide-default-footer
      :items-per-page="10"
      sort-by="name"
      class="elevation-1"
      @page-count="pageCount = $event"
    >

    <template v-slot:top>
      <v-toolbar flat>
        <v-toolbar-title> Usuarios Cadastrados </v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>

        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{on,attrs}">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              Novo Usuario
            </v-btn>
          </template>

          <v-card>
            <v-card-title>
              <span class="text-h5">Novo Usuario</span>
            </v-card-title>

            <v-card-text>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="nome"
                        :rules="nameRules"
                        v-model="editItem.name"
                        required

                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        label="email"
                        v-model="editItem.email"
                        :rules="EmailRules"
                        :error-messages="erros_message.email"
                        required
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-if="!edit_user_dialog"
                        label="senha"
                        v-model="editItem.password"
                        required
                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="PasswordRules"
                        :type="show1 ? 'text' : 'password'"
                        @click:append="show1 = !show1"
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" sm="6" md="4">
                      <v-text-field
                        v-if="!edit_user_dialog"
                        label="confirmar senha"
                        v-model="editItem.password_confirmation"
                        required
                        :append-icon="show2 ? 'mdi-eye' : 'mdi-eye-off'"
                        :rules="PasswordRules"
                        :type="show2 ? 'text' : 'password'"
                        @click:append="show2 = !show2"
                        ></v-text-field>
                    </v-col>

                  </v-row>
                </v-container>
              </v-form>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="close_dialog">
                Fechar
              </v-btn>

              <v-btn color="blue darken-1" text @click="validate">
                Salvar
              </v-btn>

            </v-card-actions>
          </v-card>
        </v-dialog>

        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title> Deseja Deletar este Usuario </v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="dialogDelete=!dialogDelete">Cancelar</v-btn>
              <v-btn color="blue darken-1" text @click="deleteUserConfirm">ok</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>


        <v-dialog v-model="dialogEdit" max-width="500px">
          <v-card>
            <v-card-title>
              <span class="text-h5">Editar Usuario</span>
            </v-card-title>
            <v-form ref="form" v-model="editValid" lazy-validation>
              <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col cols="6" sm="6" md="4">
                        <v-text-field
                          label="nome"
                          :rules="nameRules"
                          v-model="editItem.name"
                        ></v-text-field>
                      </v-col>

                      <v-col cols="6" sm="6" md="4">
                        <v-text-field
                          label="email"
                          v-model="editItem.email"
                          :rules="EmailRules"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="dialogEdit=!dialogEdit">
                  Fechar
                </v-btn>

                <v-btn color="blue darken-1" text @click="EditUserConfirm">
                  Salvar
                </v-btn>

              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>

      </v-toolbar>
    </template>

    <template v-slot:item.actions="{item}">
        <!-- <v-btn
         icon
         x-small
         class="mr-2"
         elevation="0"
         color="cyan"
        >
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
        <v-btn
          x-small
          icon
          class="mr-2"
          color="pink"
          elevation="0"
        >
          <v-icon>mdi-delete</v-icon>
        </v-btn> -->
        <v-icon small class="mr-2" @click="OpenActionDialog(item,'edit')">mdi-pencil</v-icon>
        <v-icon small @click="OpenActionDialog(item,'delete')">mdi-delete</v-icon>
    </template>





  </v-data-table>

    <!-- paginação -->
    <div class="text-center pt-2">
      <v-pagination
        v-model="page"
        v-if="!loading_data"
        :length="pageCount"
        circle
      ></v-pagination>
    </div>
  </div>
</template>


<script>
  export default{
    data(){
      return{
        // vars
        page:1,
        dialog:false,
        dialogDelete: false,
        editValid:true,
        edit_user_dialog:false,
        deleteindex:-1,
        dialogEdit:false,

        pageCount:0,
        alert_msg:'',
        alert:false,
        loading_data: true,
        valid:true,
        show1: false,
        show2:false,


        erros_message:{
          email:''
        },
        // rules
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

        editItem:{
          is_super_user:false
        },
        users:[
           {
             nome:'',
             email:'',
           }
        ],
      }
    },

    computed:{
      headers(){
       return[
          // cabecalho nome
          {
            text:'Nome',
            value:'name',
            align:'start',
          },
          // canbecalho email
          {
            text:'email',
            value:'email',
            sortable:false
          },
          {
            text:'Açôes',
            value:'actions',
            sortable:false
          },


        ];
      }
    },

    watch: {
      dialog (val) {
        val || this.close_dialog()
      },
      dialogDelete(val) {
        val || this.CloseActionDialog()
        console.log(val);
      },
      dialogEdit(val){
        val||this.CloseActionDialog()
      }
    },

    mounted(){
      this.axios
          .get('api/user')
          .then(response=>{
            this.users = response.data
            this.loading_data = false
          })
    },

    methods:{
      register(){
        this.axios
            .post('api/user', this.editItem)
            .then(response=>{
              if(response.data.status){
                this.close_dialog()
                this.refresh_data()
              }
              else
                this.erros_message = response.data.message

            })
            .catch((errors)=>{
              console.log(errors);
            })


      },

      refresh_data(){
        this.loading_data = true
        this.editItem = {
          is_super_user :false
        }
        this.axios
            .get('api/user')
            .then(response=>{
              this.users = response.data
              this.loading_data = false
            })
      },

      close_dialog(){
        this.dialog = false
        this.editItem = {
          is_super_user :false
        }
        this.reset_validation()
      },

      EditUserConfirm(){
        if(this.$refs.form.validate()){
          this.dialogEdit = false
          this.axios
              .patch('api/user/'+ this.editItem.id, this.editItem)
              .then(response=>{
                console.log(response.data);
                this.refresh_data()
              })
        }
      },

      deleteUserConfirm(){
        this.dialogDelete = false
        this.axios
            .delete('api/user/' + this.editItem.id)
            .then(response=>{
              this.refresh_data()
            })
      },

      reset_validation(){
        this.valid = true
        this.$refs.form.resetValidation()
      },

      CloseActionDialog(){
        this.deleteindex = -1
        this.reset_validation()
        this.edit_user_dialog = false
        delete this.editItem
        this.editItem = {
          is_super_user :false
        }
      },

      OpenActionDialog(item,dialog_type){
        this.editItem = Object.assign({}, item)
        if(dialog_type == 'edit')
          this.dialogEdit = true
        else if (dialog_type == 'delete') {
          this.dialogDelete = true
        }
      },

      validate(){
        if(this.$refs.form.validate()){
          this.register()
        }
      },
    }
  }
</script>

<style scoped>
.container-center{
  margin: 20px auto;
  max-width: 900px;
}
</style>
