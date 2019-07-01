import App from '../containers/App';
import VueRouter from 'vue-router'

// Import view components
import Home from '../views/Home';
import About from '../views/About';
import Contact from '../views/Contact';

// Import routes
import adminRoutes from './admin';
import dashboardRoutes from './dashboard';
import authRoutes from './auth';

let routes = [
    adminRoutes,
    dashboardRoutes,
    /*authRoutes,
    {
        path: '/',
        component: App,
        children: [
            {
                path: '',
                name: 'home',
                component: Home
            },
            {
                path: 'reeder',
                name: 'reeder',
                component: Home
            },
            {
                path: 'index.html',
                name: 'index',
                component: Home
            },
            {
                path: 'about',
                name: 'about',
                component: About
            },
            {
                path: 'contact',
                name: 'contact',
                component: Contact
            }
        ]
    }*/
];

export default new VueRouter({
    mode: 'history',
    routes
});