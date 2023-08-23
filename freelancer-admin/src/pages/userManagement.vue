<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow table-striped table-responsive">
            <div class="card-header d-flex align-items-center justify-content-between py-3 px-4 bg-light">
              <h4 class="card-title mb-0">All Users</h4>
              <router-link :to="{ name: 'Add User'}" class="btn btn-primary btn-sm"> + Add an Employee</router-link>
            </div>
            <table class="table mb-0">
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
                  <tr v-for="user in users" :key="user.id" class="border-b border-gray-200 hover:bg-gray-100 transition-all duration-300">
                      <td class="py-2 px-4">{{ user.id }}</td>
                      <td class="py-2 px-4">{{ user.name }}</td>
                      <td class="py-2 px-4">{{ user.email }}</td>
                      <td class="py-2 px-4">{{ user.role }}</td>
                      <td class="py-2 px-4 d-flex flex-wrap gap-2">
                          <router-link :to="{ name: 'View User', params: { id: user.id } }" class="btn btn-info btn-sm">View</router-link>
                          <router-link :to="{ name: 'Edit User', params: { id: user.id } }" class="btn btn-primary btn-sm">Edit</router-link>
                          <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">Delete</button>
                          <router-link :to="{name: 'Logged Time', params: {id: user.id }}" class="text-sm py-1 px-3 bg-blue-500 text-white rounded hover:bg-blue-600 transition-all duration-300">See Logged time</router-link>
                      </td>
                  </tr>
              </tbody>
            </table>
          </div>
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
