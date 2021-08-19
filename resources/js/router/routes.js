import Home from '../components/home/HomeComponent.vue';
import Login from '../components/Auth/LoginComponent.vue';
import Register from '../components/Auth/RegisterComponent.vue'
import ListarUsuarios from '../components/Admin/UsuariosComponent.vue';
import CadastroCliente from '../components/Cliente/CadastroComponent.vue';
export const routes = [
    {
      name:'Login',
      path:'/login',
      component:Login,
      meta:{guest:true}
    },

    {
      name:'Register',
      path:'/register',
      component:Register,
      meta:{guest:true}
    },

    // rotas se  o Usuario estiver autenticadd
    {
        name:'home',
        path:'/',
        component:Home,
        meta: {requiresAuth: true}
    },
    {
      name:'CadastroCliente',
      path:'/CadastroCliente',
      component:CadastroCliente,
      meta:{requiresAuth:true}
    }, 

    {
      name:'ListarUsuarios',
      path:'/Users',
      component:ListarUsuarios,
      meta:{requiresAuth:true}
    }

];
