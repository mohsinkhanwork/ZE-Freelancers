<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <card class="card table-striped table-responsive">
            <div class="card-header flex p-0">
              <div class="p-2">
                <h4 class="card-title">
                  All Users
                </h4>
              </div>
              <div class="ml-auto p-2">
                <router-link :to="{ name: 'Add User'}" class="btn btn-primary btn-sm active"> + Add an Employee</router-link>
              </div>
            </div>
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th>ID</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users" :key="user.id">
                  <td>{{ user.id }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.role }}</td>
                  <td>
                    <router-link :to="{ name: 'View User', params: { id: user.id } }" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium
                    rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">View</router-link>

                    <router-link :to="{ name: 'Edit User', params: { id: user.id } }" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4
                    focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Edit</router-link>

                    <button
                      @click="deleteUser(user.id)"
                      class="ml-1.5 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5
                      mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-90">Delete</button>
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
    computed: {
      ...mapState(['users'])
    },
    created () {
      this.getAllUsers()
    },
    methods: {
      ...mapActions([
        'getAllUsers'
      ]),
      deleteUser (id) {
       if (confirm('Are you sure you want to delete this user?')) {
        axios.delete(`${axiosConfig.baseURL}/deleteUser`, {
          data: {
            id: id
          }
        }) // axios.delete(`${axiosConfig.baseURL}/deleteUser/${id}`) // This is the old way of doing it
        .then(response => {
          if(response.data.success) {
            this.getAllUsers()
            alert('User deleted successfully')
          } else {
            alert('Error deleting user' + response.data.message);
          }
        })
        .catch(error => {
          alert('Error deleting user' + error.message);
        })
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
