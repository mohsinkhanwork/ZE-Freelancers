<template>
  <card>
    <h4 slot="header" class="card-title">Edit User info</h4>
    <form>
      <div>
        the user is not availble for further use
      </div>
      <div class="row">
        <div class="col-md-5">
          <base-input type="text"
                    label="Company"
                    placeholder="Light dashboard"
                    v-model="user.user_data.company
                    ">
          </base-input>
        </div>
        <div class="col-md-3">
          <base-input type="text"
                    label="Username"
                    placeholder="Username"
                    v-model="user.name">
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input type="email"
                    label="Email"
                    placeholder="Email"
                    v-model="user.email">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <base-input type="text"
                    label="First Name"
                    placeholder="First Name"
                    v-model="user.user_data.first_name">
          </base-input>
        </div>
        <div class="col-md-6">
          <base-input type="text"
                    label="Last Name"
                    placeholder="Last Name"
                    v-model="user.user_data.last_name">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <base-input type="text"
                    label="Address"
                    placeholder="Home Address"
                    v-model="user.user_data.address">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <base-input type="text"
                    label="City"
                    placeholder="City"
                    v-model="user.user_data.city">
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input type="text"
                    label="Country"
                    placeholder="Country"
                    v-model="user.user_data.country">
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input type="number"
                    label="Postal Code"
                    placeholder="ZIP Code"
                    v-model="user.user_data.postal_code">
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>About Me</label>
            <textarea rows="5" class="form-control border-input"
                      placeholder="Here can be your description"
                      v-model="user.user_data.description">
              </textarea>
          </div>
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-info btn-fill float-right" @click.prevent="updateUserProfile">
          Update Profile
        </button>
      </div>
      <div class="clearfix"></div>
    </form>
  </card>
</template>
<script>
  import Card from 'src/components/Cards/Card.vue'
  import { mapState , mapActions} from 'vuex';

  export default {
    computed: {
      user: {
        get() {
          return this.$store.state.currentEditUser;
        },
        set(newUser) {
          this.$store.commit('setCurrentEditUser', newUser);
        }
      }
    },

    data () {
      return {
      }
    },

    async created () {
      const userId = this.$route.params.id;
      const user = this.$store.state.users.find(user => user.id === userId);
      await this.$store.dispatch('fetchUserById', user);
    },

    methods: {
      ...mapActions(['getUser']),
      async updateUserProfile() {
        try {
        const updatedUser = await this.$store.dispatch('updateUserProfile', this.user);
        alert('User updated successfully');
        } catch (error) {
         alert('Error updating user', error);
        }
      },
    },

    watch: {
  'user': {
    handler(newUser) {
        this.user = newUser; // update local data when Vuex state changes
    },
    deep: true // ensure watcher triggers for nested data changes
  }
},



    components: {
      Card
    },
  }

</script>
<style>

</style>
