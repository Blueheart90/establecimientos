import Vue from 'vue';
import VueRouter from 'vue-router'
import InicioEstablecimientos from '../components/InicioEstablecimientos';
import MostrarEstablecimiento from '../components/MostrarEstablecimiento'

// Array para las rutas
const routes = [
    {
        path: '/',
        component: InicioEstablecimientos
    },
    {
        path: '/establecimiento/:id',
        name: "establecimiento",
        component: MostrarEstablecimiento
    }
]

const router = new VueRouter({
    mode: 'history', // para que no salga # en la url
    routes
});

Vue.use(VueRouter);

export default router;
