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
      loading: false,
      timerActive: false,
      startTime: null,
      endTime: null,
      logs: []

  },
  mutations: {
      setUser (state, user) {
          state.user = user;
      },
      SET_USER_IMAGE(state, imageURL) {
        state.user.user_data.image = imageURL;
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
      },
      startTimer(state) {
        state.timerActive = true;
        state.startTime = new Date().toISOString(); // ISO string format is a good choice
      },
      stopTimer(state) {
          state.timerActive = false;
          state.endTime = new Date().toISOString();
      },
      addLog(state, log) {
          state.logs.push(log);
      },
      updateLogDescription(state, { logId, description }) {
        const log = state.logs.find(log => log.id === logId);
        if (log) {
            log.description = description;
        }
     },
     setLogs(state, logs) {
      state.logs = logs;
    }

  },
actions: {
  async addNewUserToServer({commit}, userData) {
    let response;
    try {
        response = await axios.post(`${axiosConfig.baseURL}/add-user`, userData);
        if (response && response.status === 200) {
          commit('setUser', response.data);
          commit('setCurrentUser', response.data);
          return response.data;
        }
    } catch (e) {
        console.error('Error adding new user', e);
        throw e;
    } finally {
      commit('setLoading', false);
    }
  },
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
    if(response && response.status === 200) {
      commit('setRoles', response.data);
      return response.data;
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
    console.log('response', response);
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

  },
    async saveLog({ commit }, logData) {
      try {
          const response = await axios.post(`${axiosConfig.baseURL}/manual-entry`, logData);
          console.log("Saved Log Data:", response.data); //
          commit('addLog', response.data);
      } catch (e) {
        console.log(e.response);
          let errorMessage = e.response && e.response.data && e.response.data.message
                             ? e.response.data.message
                             : 'Error saving the log';
          throw new Error(errorMessage);
        }
    },
    async fetchLogs({commit, state}) {
      let response;
      try {
        response = await axios.get(`${axiosConfig.baseURL}/timelogs/${state.currentUser.id}`);
        console.log("Logs from Backend:", response.data);
          if (response && response.status === 200) {
              commit('setLogs', response.data.data);
          }
      } catch (e) {
          console.error('Error fetching logs', e);
          throw e;
      }
  },
  },
  plugins: [VuexPersistedState()]
});
