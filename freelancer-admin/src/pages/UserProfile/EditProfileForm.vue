<template>
  <card>
    <h4 slot="header" class="card-title">Edit Profile</h4>
    <form>
      <div class="row">
        <div class="col-md-5">
          <base-input
            type="text"
            label="Company"
            placeholder="Light dashboard"
            v-model="localUser && localUser.user_data.company"
          >
          </base-input>
        </div>
        <div class="col-md-3">
          <base-input
            type="text"
            label="Username"
            placeholder="Username"
            v-model="localUser.name"
          >
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input
            type="email"
            label="Email"
            placeholder="Email"
            v-model="localUser.email"
          >
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <base-input
            type="text"
            label="First Name"
            placeholder="First Name"
            v-model="localUser && localUser.user_data.first_name"
          >
          </base-input>
        </div>
        <div class="col-md-6">
          <base-input
            type="text"
            label="Last Name"
            placeholder="Last Name"
            v-model="localUser && localUser.user_data.last_name"
          >
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <base-input
            type="text"
            label="Address"
            placeholder="Home Address"
            v-model="localUser && localUser.user_data.address"
          >
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <base-input
            type="text"
            label="City"
            placeholder="City"
            v-model="localUser && localUser.user_data.city"
          >
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input
            type="text"
            label="Country"
            placeholder="Country"
            v-model="localUser && localUser.user_data.country"
          >
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input
            type="number"
            label="Postal Code"
            placeholder="ZIP Code"
            v-model="localUser && localUser.user_data.postal_code"
          >
          </base-input>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label>About Me</label>
            <textarea
              rows="5"
              class="form-control border-input"
              placeholder="Here can be your description"
              v-model="localUser && localUser.user_data.description"
            >
            </textarea>
          </div>
        </div>
      </div>
      <div class="text-center">
        <button
          type="submit"
          class="btn btn-info btn-fill float-right"
          @click.prevent="updateProfile"
        >
          Update Profile
        </button>
      </div>
      <div class="clearfix"></div>
    </form>
  </card>
</template>
<script>
import Card from 'src/components/Cards/Card.vue';
import { mapState, mapActions } from 'vuex';

export default {
  computed: {
    ...mapState({
      stateUser: (state) => state.user,
    }),
  },

  components: {
    Card,
  },
  data() {
    return {
      // user: this.$store.state.user,
      loading: true,
      localUser: {
        id: '',
        user_data: {
          company: '',
          first_name: '',
          last_name: '',
          address: '',
          city: '',
          country: '',
          postal_code: '',
          description: '',
        },
        name: '',
        email: '',
      },
    };
  },
  methods: {
    ...mapActions(['updateUserProfile']),
    async updateProfile() {
      try {
        const updatedUser = await this.updateUserProfile(this.localUser);
        this.$store.commit('setUser', updatedUser);
        this.user = Object.assign({}, updatedUser);
        alert('Profile updated successfully');
      } catch (error) {
        console.log(error);
        alert('Error updating profile');
      }
    },
  },
  created() {
    if (this.stateUser) {
      this.localUser.id = this.stateUser.id;
      if (this.stateUser.user_data) {
        this.localUser.user_data = Object.assign({}, this.stateUser.user_data);
      }
      this.localUser.name = this.stateUser.name;
      this.localUser.email = this.stateUser.email;
    }
  },
  watch: {
    stateUser: {
      // watch it
      handler(newUser) {
        if (newUser) {
          this.localUser.id = newUser.id;
          if (newUser.user_data) {
            this.localUser.user_data = Object.assign({}, newUser.user_data);
          }
          this.localUser.name = newUser.name;
          this.localUser.email = newUser.email;
        }
      },
      deep: true, // ensure watcher triggers for nested data changes
    },
  },
};
</script>
<style></style>
