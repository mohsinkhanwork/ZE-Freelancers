<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <card class="card table-striped table-responsive">
            <template slot="header">
              <h4 class="card-title">Roles</h4>
            </template>
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="role in roles" :key="role.id">
                  <td>{{ role.id }}</td>
                  <td>{{ role.name }}</td>
                </tr>
              </tbody>
            </table>
            <input type="text" class="form-control"
            v-model="roleName"
            placeholder="Enter Role Name">
            <button class="btn btn-primary btn-sm" @click="addRole">
              Add Role
            </button>
          </card>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <card class="card table-striped table-responsive">
            <template slot="header">
              <h4 class="card-title">All Users</h4>
            </template>
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Select Assigned role</th>
                  <!-- Other columns here -->
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>
                    <select class="form-control" v-model="user.role" @change="updateRole(user.id)">
                      <option v-for="role in roles" :key="role.id" :value="role.name">
                        {{ role.name }}
                      </option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </card>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from 'vuex'
import Card from 'src/components/Cards/Card.vue'
import axios from 'axios'
import axiosConfig from '../axios';

export default {
  data () {
    return {
      roleName: '',
    }
  },
  computed: {
    ...mapState([
      'users',
      'roles'
    ])
  },
  created () {
    this.getAllUsers(),
    this.getAllRoles()
  },
  methods: {
    ...mapActions([
      'getAllUsers',
      'getAllRoles'
    ]),
    async addRole () {
      try {
        let response = await axios.post('/add-roles', {
          name: this.roleName
        }, axiosConfig);
        this.roles.push(response.data); //here we push the new role to the roles array
        this.roleName = ''; // clear input field
      } catch (error) {
        console.error(error);
      }
    },

    async updateRole (userId) {
      let user = this.users.find(user => user.id === userId);
      if (user) {
        try {
          await axios.post('/update-role', {
            role: user.role,
            userId: userId
          }, axiosConfig);
          // No need to push to roles or clear roleName here
        } catch (error) {
          console.error(error);
        }
      }
    }
  },
  components: {
    Card
  },
}
</script>

<style>
</style>
