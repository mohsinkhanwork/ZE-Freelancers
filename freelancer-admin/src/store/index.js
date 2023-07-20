import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistedState from 'vuex-persistedstate';

import axios from 'axios';
import axiosConfig from '../axios.js';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
      user: null,
      token: null,
      users: [],
      roles: [],
      currentEditUser: null,
      currentUser: null,
      loading: false
  },
  mutations: {
    setUser (state, user) {
        state.user = user;
    },
    setToken (state, token) {
        state.token = token;
    },
    setUsers (state, users) {
        state.users = users;
    },
    setRoles (state, roles) {
        state.roles = roles;
    },
    addRole (state, role) {
        state.roles.push(role);
    },
    setLoading (state, loading) {
        state.loading = loading;
    },
    setCurrentEditUser (state, user) {
        state.currentEditUser = user;
    },
    setCurrentUser (state, user) {
        state.currentUser = user;
    }
  },
actions: {
  async updateUserProfile({commit}, userData) {
    let response;
    try {
       response = await axios.put(`${axiosConfig.baseURL}/user/${userData.id}`, userData);
       if (response && response.status === 200) {
        commit('setUser', response.data);
        commit('setCurrentUser', response.data);
        return response.data;
     }
    } catch (e) {
       console.error('Error updating user profile', e);
       throw e;
    }

  },
  async updateEachUserProfile({commit}, userData) {
    let response;

    try {
       response = await axios.put(`${axiosConfig.baseURL}/user/${userData.id}`, userData);
       if (response && response.status === 200) {
        // commit('setUser', response.data);
        commit('setCurrentEditUser', response.data);
        alert("User updated successfully");
        return response.data;
     }
    } catch (e) {
       console.error('Error updating user profile', e);
       throw e;
    }

  },
  async getAllUsers({commit}) {
    let response;
    try {
       response = await axios.get(`${axiosConfig.baseURL}/get-users`);
       if (response && response.status === 200) {
        commit('setUsers', response.data);
     }
    } catch (e) {
       console.error('Error getting all users', e);
       throw e;
    }

  },
  async getAllRoles({commit}) {
    let response;
    try {
       response = await axios.get(`${axiosConfig.baseURL}/get-roles`);
    } catch (e) {
       console.error('Error getting all roles', e);
       throw e;
    }
    if (response && response.status === 200) {
       commit('setRoles', response.data);
    }
  },
  async createRole({ commit }, roleData) {
    response = await axios.get(`${axiosConfig.baseURL}/add-roles`);
    commit('addRole', response.data);
  },
  async fetchUserById({ commit }, userId) {
    let response;
    try {
      commit('setLoading', true);
       response = await axios.get(`${axiosConfig.baseURL}/get-user/${userId}`);
       if (response && response.status === 200) {
        commit('setCurrentEditUser', response.data);
     }
    } catch (e) {
       console.error('Error getting user', e);
       throw e;
    } finally {
      commit('setLoading', false);
    }

  }
},

  plugins: [VuexPersistedState()]
});
