<template>
  <div class="wrapper">
    <side-bar>
      <mobile-menu slot="content"></mobile-menu>
      <router-link to="/admin/overview" class="sideBar">
        <i class="nc-icon nc-chart-pie-35"></i>
        <p>Dashboard</p>
      </router-link>
      <router-link to="/admin/user" class="sideBar">
        <i class="nc-icon nc-circle-09"></i>
        <p>User Profile</p>
      </router-link>
      <router-link v-if="user.role == 'admin'" class="sideBar"
      to="/admin/user-management">
        <i class="nc-icon nc-notes"></i>
        <p>User Management</p>
      </router-link>
      <router-link v-if="user.role == 'admin'" class="sideBar"
      to="/admin/user-role">
        <i class="nc-icon nc-notes"></i>
        <p>Role Management</p>
      </router-link>
    </side-bar>
    <div class="main-panel">
      <top-navbar></top-navbar>

      <dashboard-content @click="toggleSidebar">

      </dashboard-content>

      <content-footer></content-footer>
    </div>
  </div>
</template>
<style lang="scss">

</style>
<script>
  import TopNavbar from './TopNavbar.vue'
  import ContentFooter from './ContentFooter.vue'
  import DashboardContent from './Content.vue'
  import MobileMenu from './MobileMenu.vue'
  import { mapState, mapActions } from 'vuex'
  export default {
    computed: {
      ...mapState({
        user: state => state.user
      })
    },

    data () {
      return {
      }
    },

    components: {
      TopNavbar,
      ContentFooter,
      DashboardContent,
      MobileMenu
    },
    methods: {
      toggleSidebar () {
        if (this.$sidebar.showSidebar) {
          this.$sidebar.displaySidebar(false)
        }
      }
    }
  }

</script>

<style>
  .sideBar {
    color: white;
    display: flex;
    padding: 0px 0px 0px 21px;
  }

  .nc-icon {
    margin-right: 10px;
  }
</style>
