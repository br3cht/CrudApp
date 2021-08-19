<template>
  <div>
    <div class="container-center">

      </v-expansion-panels>
      <v-alert :value="alert" transition="scale-transition" type="success" elevation="5"> Cliente Cadastrado com Sucesso</v-alert>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-expansion-panels
          >
          <v-expansion-panel>
            <v-expansion-panel-header>Dados do Cliente</v-expansion-panel-header>
            <v-expansion-panel-content>
              <v-row>
                <!-- Nome -->
                <v-col cols="12" md="4">
                  <v-text-field
                  v-model="cliente.nome"
                  :rules="nameRules"
                  :counter="10"
                  label = "Nome"
                  required
                  ></v-text-field>
                </v-col>

                <!-- sobrenome -->
                <v-col cols="12" md="4">
                  <v-text-field
                  v-model="cliente.sobrenome"
                  :rules="sobrenomeRules"
                  :counter="10"
                  label = "SobreNome"
                  required
                  ></v-text-field>
                </v-col>

                <!-- idade -->
                <v-col cols="12" md="4">
                  <v-dialog
                    ref="dialog"
                    v-model="modal_date"
                    persistent
                    width="290px"
                  >
                  <template v-slot:activator="{on, attrs}">
                    <v-text-field
                      v-model="cliente.datanascimento"
                      label = "Data Nascimento"
                      prepend-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                      :rules="localizacaoRules"
                      required
                    ></v-text-field>
                  </template>

                  <v-date-picker
                    v-model="cliente.datanascimento"
                    locale="pt-br"
                    scrollable
                  >
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="modal_date = false"
                    >
                     ok
                    </v-btn>

                  </v-date-picker>

                </v-dialog>

                </v-col>
                <!-- Sexo -->
                <v-col cols="12" md="6">
                  <v-select
                    v-model="cliente.sexo"
                    :items="items"
                    :rules="[v=>!!v||'Necessario Selecionar']"
                    label="Sexo"
                    required
                  ></v-select>
                </v-col>

                <!-- CPF -->
                <v-col cols="12" md="6">
                  <v-text-field
                  v-model="cliente.cpf"
                  :rules="cpfRules"
                  :counter="11"
                  maxlength="11"
                  label = "CPF"
                  :error-messages="erros.cpf"
                  required
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-expansion-panel-content>
          </v-expansion-panel>

          <v-expansion-panel>
            <v-expansion-panel-header> Contato</v-expansion-panel-header>
            <v-expansion-panel-content>
              <v-row>
                <!-- telefone -->
                <v-col cols=12 md="6">
                  <v-text-field
                    v-model="cliente.telefone"
                    :counter="11"
                    :rules = "TelefoneRules"
                    maxlength="11"
                    label="telefone"
                    :error-messages="erros.telefone"
                    required
                  ></v-text-field>
                </v-col>

                <!-- Email  -->
                <v-col cols=12 md="6">
                  <v-text-field
                    v-model="cliente.email"
                    :rules = "EmailRules"
                    label="Email"
                    required
                    :error-messages="erros.email"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-expansion-panel-content>
          </v-expansion-panel>

          <v-expansion-panel>
            <v-expansion-panel-header> Localização</v-expansion-panel-header>
            <v-expansion-panel-content>
              <!-- Cep -->
              <v-row>
                <v-col cols=12 md="4">
                  <v-text-field
                    v-model="cep"
                    label = "CEP"
                    maxlength = "8"
                    @keyup="searchCep()"
                  ></v-text-field>
                </v-col>
              </v-row>


              <v-row>
                <!-- Cidade -->
                <v-col cols=12 md="4">
                  <v-text-field
                    v-model="cliente.cidade"
                    label = "Cidade"
                    :rules="localizacaoRules"
                    required
                  ></v-text-field>
                </v-col>

                <!-- Endereco -->
                <v-col cols=12 md="4">
                  <v-text-field
                    v-model="cliente.endereco"
                    label = "Endereco"
                    :rules="localizacaoRules"
                    required
                  ></v-text-field>
                </v-col>

                <!-- UF -->
                <v-col cols="12" md="4">
                  <v-text-field
                    v-model="cliente.uf"
                    label = "UF"
                    :rules="localizacaoRules"
                    required
                  ></v-text-field>
                </v-col>


              </v-row>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
            <!-- butoes submit -->
            <div class="text-right">
              <v-btn fab dark small color="error" class="mr-4">
                <v-icon>mdi-close</v-icon>
              </v-btn>
              <v-btn fab dark small :disable="!valid" color="success" class="mr-4" @click="validate">
                   <v-icon>mdi-check</v-icon>
              </v-btn>
            </div>
          </v-container>
        </v-form>
    </div>
  </div>
</template>

<script>
  export default{
    data(){
      return{
        panel: [0, 1],
        readonly: false,
        modal_date_inicio: false,
        valid: true,
        modal_date:false,
        modal_date2:false,
        cidade:null,
        alert:false,
        transition: '',
        erros:{
          email:'',
          cpf:'',
          telefone:''
        },

        cep:'',

        informacoes_localizacao:{
          cidade:'',
          endereco:'',
          uf:'',
        },

        cliente:{
          cidade:'',
          endereco:'',
          uf:'',
        },

        localizacaoRules:[
          v => !!v || 'Preenchimento Necessario',
        ],

        nameRules:[
         v => !!v || 'Preenchimento Necessario',
         v => (v && v.length <= 10) || 'Ultrapssou o Limite',
        ],

        sobrenomeRules:[
          v => !!v || 'Preenchimento Necessario',
          v => (v && v.length <= 11) || 'Ultrapssou o Limite',
        ],

        cpfRules:[
          v => !!v || 'Preenchimento Necessario',
          v => (v && v.length == 11) || 'Cpf Numero reduzido',
        ],

        EmailRules:[
          v => !!v || 'Preenchimento Necessario',
          v => /.+@.+\..+/.test(v) || 'E-mail Não Valido',
        ],

        TelefoneRules:[
          v => !!v || 'Preenchimento Necessario',
          v => (v && v.length == 11) || 'Telefone reduzido',
        ],

        err:'',
        items:[
          "Masculino",
          "Feminino",
        ],


      }
    },

    methods:{
      addAluno(){
        var token = localStorage.getItem('token')
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
        this.axios
            .post('api/cliente', this.cliente)
            .then(response=>{
              console.log(response.data);
              if (response.data.sucess == 0){
                if(response.data.message.email != null)
                    this.erros.email = response.data.message.email[0]

                if(response.data.message.telefone != null )
                  this.erros.telefone = response.data.message.telefone[0]

                if(response.data.message.cpf != null)
                  this.erros.cpf = response.data.message.cpf[0]
              }
              else if (response.data.sucess == 1) {
                this.openAlert()
                this.cliente = {
                  cidade:'',
                  endereco:'',
                  uf:'',
                }
              }
            })
            .catch(err => console.log(err))
            .finally(()=>this.loading = false)
      },

      validate(){
        if(this.$refs.form.validate() && this.cliente.datanascimento != null)
          this.addAluno();
      },

      openAlert(){
        window.scroll(0, 0)
        this.alert = true
        setTimeout(() => {this.alert = false}, 5000)

      },

      searchCep(){
        if(this.cep.length == 8){
              delete axios.defaults.headers.common.Authorization
              axios.get(`https://viacep.com.br/ws/${ this.cep }/json/`)
              .then(response=>{
                this.cliente.endereco = response.data.logradouro;
                this.cliente.cidade = response.data.localidade;
                this.cliente.uf = response.data.uf;
              })
              .catch(error=>{
                console.log(error);
              })
        }
      },

    validarCPf(){
        var cpf = "1114447770";
        var string = cpf.slice(0,9);

        string = string.concat(this.CalcularDigitos(string, 10));
        string = string.concat(this.CalcularDigitos(string, 11));

        if(string == cpf){
          console.log("valido");
        }
        else {
          console.log("Invalido");
        }
    },


    CalcularDigitos(string, valor){
      var resultado = 0;

      for (var i = 0; i < string.length; i++) {
        resultado = resultado + (string[i] * valor);
        valor = valor - 1;
      }
      resultado = resultado % 11;

      if(resultado < 2)
         return resultado
      else if (resultado >= 2) {
         resultado = 11 - resultado;
         return resultado.toString();

      }
    }




  }
}

</script>

<style scoped>
 .container-center{
   max-width: 800px;
   width: 100%;
   margin:40px auto;
 }
</style>
