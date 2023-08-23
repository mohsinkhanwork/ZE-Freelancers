import DashboardLayout from '../layout/DashboardLayout.vue'
import NotFound from '../pages/NotFoundPage.vue'


// Admin pages
import Overview from 'src/pages/Overview.vue'
import UserProfile from 'src/pages/UserProfile.vue'
import userManagement from 'src/pages/userManagement.vue'
import userRole from 'src/pages/userRole.vue'
import Login from 'src/pages/login.vue'
import Register from 'src/pages/Register.vue'
import Callback from 'src/pages/Callback.vue'
import store from '../store/index.js';
import editUser from "src/pages/editUser";
import addUser from "src/pages/addUser";
import userTime from "src/pages/userTime";
import AdminLoggedTime from "src/pages/AdminLoggedTime";

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
      if (store.state.token) {
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
        path: 'user-management',
        name: 'User Management',
        component: userManagement
      },
      {
        path: 'user-role',
        name: 'User Role',
        component: userRole
      },
      {
        path: 'edit-user/:id',
        name: 'Edit User',
        component: editUser,
        meta : { editMode: true }
      },
      {
        path: 'add-user',
        name: 'Add User',
        component: addUser,
      },
      {
        path: 'view-user/:id',
        name: 'View User',
        component: editUser,
        meta : { editMode: false }
      },
      {
        path: 'user-time',
        name: 'User Time',
        component: userTime,
      },
      {
        path: 'time-logs/:id',
        name: 'Logged Time',
        component: AdminLoggedTime,
      }
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
    path: '/callback',
    name: 'Callback',
    component: Callback,
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
