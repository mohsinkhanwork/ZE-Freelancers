import DashboardLayout from '../layout/DashboardLayout.vue'
import NotFound from '../pages/NotFoundPage.vue'


// Admin pages
import Overview from 'src/pages/Overview.vue'
import UserProfile from 'src/pages/UserProfile.vue'
import TableList from 'src/pages/TableList.vue'
import Login from 'src/pages/login.vue'
import Register from 'src/pages/Register.vue'

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/admin/overview'
  },
  {
    path: '/admin',
    component: DashboardLayout,
    redirect: '/admin/overview',
    beforeEnter: (to, from, next) => {
      if (sessionStorage.getItem('Bearer_token')) {
        next();
      } else {
        next({name: 'Login'});
      }
    },
    children: [
      {
        path: 'overview',
        name: 'Overview',
        component: Overview
      },
      {
        path: 'user',
        name: 'User',
        component: UserProfile
      },
      {
        path: 'table-list',
        name: 'Table List',
        component: TableList
      },
    ]
  },
  {
    path: '/login',
    name: 'Login',
    component: Login

  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path: '*',
    component: NotFound
  }
]

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes
