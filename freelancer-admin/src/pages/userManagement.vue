<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card shadow">
            <div class="card-header d-flex align-items-center justify-content-between py-3 px-4 bg-light">
  <h4 class="card-title mb-0">All Users</h4>
  <div class="d-flex align-items-center">
    <input type="text" v-model="searchQuery" placeholder="Search by name..." class="form-control mr-3" style="width: 250px;"> <!-- Adjust the width as needed -->
    <router-link :to="{ name: 'Add User'}" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 transition-all duration-300">Add Employee</router-link>
  </div>
</div>


            <div class="table-responsive">
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
                  <tr v-for="user in filteredUsers" :key="user.id" class="border-b border-gray-200 hover:bg-gray-100 transition-all duration-300">
                    <td class="py-2 px-4">{{ user.id }}</td>
                    <td class="py-2 px-4">{{ user.name }}</td>
                    <td class="py-2 px-4">{{ user.email }}</td>
                    <td class="py-2 px-4">{{ user.role }}</td>
                    <td class="py-2 px-4">
                      <router-link :to="{ name: 'View User', params: { id: user.id } }" class="btn btn-outline-info btn-sm mr-2">View</router-link>
                      <router-link :to="{ name: 'Edit User', params: { id: user.id } }" class="btn btn-outline-primary btn-sm mr-2">Edit</router-link>
                      <button @click="deleteUser(user.id)" class="btn btn-outline-danger btn-sm mr-2">Delete</button>
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
  </div>
</template>





<script>
  import { mapActions, mapState } from 'vuex'
  import Card from 'src/components/Cards/Card.vue'
  import axios from 'axios'
  import axiosConfig from '../axios';
  export default {
    data() {
  return {
    searchQuery: ''
  };
},
    computed: {
      ...mapState(['users']),
      filteredUsers() {
        if (this.searchQuery) {
          const queryLower = this.searchQuery.toLowerCase();
          return this.users.filter(user => user.name.toLowerCase().includes(queryLower));
        }
        return this.users;
      }
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
