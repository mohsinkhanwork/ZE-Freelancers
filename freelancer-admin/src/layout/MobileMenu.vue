<template>
  <ul class="nav nav-mobile-menu">
    <li class="nav-item">
      <a href="#" class="nav-link">
        <i class="nc-icon nc-zoom-split hidden-lg-up"></i>
        <span class="d-lg-none">Search</span>
      </a>
    </li>
    <base-dropdown title="Dropdown">
      <a class="dropdown-item" href="#">Action</a>
      <a class="dropdown-item" href="#">Another action</a>
      <a class="dropdown-item" href="#">Something</a>
      <a class="dropdown-item" href="#">Something else here</a>
      <div class="divider"></div>
      <a class="dropdown-item" href="#">Separated link</a>
    </base-dropdown>

    <li class="nav-item">
      <a class="nav-link" href="#" @click="handleLogout">
        <span class="no-icon">Log out</span>
      </a>
    </li>
  </ul>
</template>
<script>
import { logout } from '../auth';
  export default {
    name: 'mobile-menu',

    methods: {
      handleLogout () {
        logout()
        this.$router.push({name: 'Login'})
      }
    }

  }
</script>
<style>
</style>
