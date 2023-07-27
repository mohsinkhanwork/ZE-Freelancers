<template>
  <div class="content">
  <div class="col-lg-12 position-relative z-index-2">
    <div class="row">
      <div class="col-lg-5 col-sm-5">
        <div class="card mb-2">
          <div class="card-header p-3 pt-2 bg-gradient-to-r from-indigo-400">
            <div class="mt-n4">
              <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path>
              </svg>
              </div>
            </div>
            <div class="text-end pt-1 mt-3">
              <p class="text-sm mb-0 text-capitalize">Absences</p>
              <h4 class="mb-0">2,300</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3"></div>
        </div>
        <div class="card mb-2 mt-5">
          <div class="card-header p-3 pt-2 bg-gradient-to-r from-indigo-700 from-10% via-sky-600 via-30% to-emerald-600 to-40%">
            <div class="mt-n4">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
              </svg>
            </div>
            <div class="text-end pt-1 mt-3">
              <p class="text-sm mb-0 text-capitalize">Open Application</p>
              <h4 class="mb-0">2,300</h4>
            </div>
          </div>
          <hr class="dark horizontal my-0">
          <div class="card-footer p-3"></div>
        </div>
      </div>
      <div class="col-lg-5 col-sm-5 mt-sm-0 mt-4">
        <div class="card mb-2">
          <div class="card-header p-3 pt-2 bg-gradient-to-r from-indigo-400 via-purple-500 to-pink-400">
            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
              <router-link :to="{ name: 'Add User'}" class="btn btn-primary btn-sm active">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path>
              </svg>
            </router-link>
            </div>
            <div class="text-end pt-1 mt-3">
              <p class="text-sm mb-0 text-capitalize text-white">
                Add Employee
              </p>
              <h4 class="mb-0">
                <span v-for="user in users" :key="user.id">
                  {{ user.name }}
                </span>
              </h4>
            </div>
          </div>
          <hr class="horizontal my-0 dark">
          <div class="card-footer p-3"></div>
        </div>
        <div class="card mt-5">
          <div class="card-header p-3 pt-2 bg-gradient-to-r from-green-400 to-blue-500">
            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"></path>
              </svg>
            </div>
            <div class="text-end pt-1 mt-3">
              <p class="text-sm mb-0 text-capitalize">News</p>
              <h4 class="mb-0">+91</h4>
            </div>
          </div>
          <hr class="horizontal my-0 dark">
          <div class="card-footer p-3"></div>
        </div>
      </div>
    </div>
  </div>
</div>
</template>
<script>
  import { mapState } from 'vuex';


  export default {
    computed: {
      ...mapState([
        'users',
      ])
    },
    data () {
      return {
      }
    },
    created () {
      this.getAllUsers();
    },
  }
</script>
