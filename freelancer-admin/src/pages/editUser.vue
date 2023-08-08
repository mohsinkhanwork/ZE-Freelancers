<template>
  <div v-if="loading">Loading...</div>
  <div v-else-if="!user || !user.user_data">
    <p>No user data available.</p>
</div>

  <card v-else class="shadow">
    <h4 slot="header" class="card-title mb-4">Edit User info</h4>
    <form>
      <div class="form-row">
        <div class="form-group col-md-5">
          <base-input type="text" label="Company" v-model="user.user_data.company" placeholder="Light dashboard"/>
        </div>
        <div class="form-group col-md-3">
          <base-input type="text" label="Username" v-model="user.name" placeholder="Username"/>
        </div>
        <div class="form-group col-md-4">
          <base-input type="email" label="Email" v-model="user.email" placeholder="Email"/>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <base-input type="text" label="First Name" v-model="user.user_data.first_name" placeholder="First Name"/>
        </div>
        <div class="form-group col-md-6">
          <base-input type="text" label="Last Name" v-model="user.user_data.last_name" placeholder="Last Name"/>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">
          <base-input type="text" label="Address" v-model="user.user_data.address" placeholder="Home Address"/>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-4">
          <base-input type="text" label="City" v-model="user.user_data.city" placeholder="City"/>
        </div>
        <div class="form-group col-md-4">
          <base-input type="text" label="Country" v-model="user.user_data.country" placeholder="Country"/>
        </div>
        <div class="form-group col-md-4">
          <base-input type="number" label="Postal Code" v-model="user.user_data.postal_code" placeholder="ZIP Code"/>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">
          <label for="position">Position</label>
          <select class="form-control" v-model="user.role">
            <option disabled value="">Please assign role</option>
            <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-12">
          <label>About Me</label>
          <textarea rows="5" class="form-control border-input" v-model="user.user_data.description" placeholder="Here can be your description"></textarea>
        </div>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-info btn-fill btn-lg mt-4" @click.prevent="submitUpdateUserProfile"
        v-if="$route.meta.editMode">
          Update Profile
        </button>
      </div>
    </form>
  </card>
</template>





<script>
  import Card from 'src/components/Cards/Card.vue'
  import { mapState , mapActions} from 'vuex';

  export default {
    computed: {
      ...mapState(['loading', 'currentEditUser', 'roles']),
      user: {
        get() {
          let user = this.$store.state.currentEditUser;
          if (!user.user_data && user.userData) {
            user.user_data = user.userData;
          }
          return user;
        },
        set(newUser) {
          this.$store.commit('setCurrentEditUser', newUser);
        }
      }
    },

    state: {
      currentEditUser: {
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
},

  data () {
    return {
        error: null,
    };
  },


    async created() {
        const roles = await this.getAllRoles();
        if(roles && roles.length) {
          this.roles = roles;
        }
        const userId = this.$route.params.id;
        this.$store.commit('setCurrentEditUser', {
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
        role: '',
      });

  try {
    const user = await this.$store.dispatch('fetchUserById', userId);
    if(user) {
      // Create a copy of the user object before committing to Vuex state
      this.$store.commit('setCurrentEditUser', { ...user });
    } else {
      console.error('Unable to fetch user by ID');
    }
  } catch(err) {
    this.error = "Error fetching user data. Please try again.";
    console.error('Error fetching user by ID', err);
  }
},

    methods: {
      ...mapActions(['updateEachUserProfile', 'getAllRoles']),
      async submitUpdateUserProfile() {
        try {
          await this.updateEachUserProfile(this.user);
        } catch (error) {
         alert('Error updating user');
         console.error(error);
        }
      },
    },

    watch: {
    'user': {
      handler(newUser, oldUser) {
        if (JSON.stringify(newUser) !== JSON.stringify(oldUser)) {
        }
      },
      deep: true
    }
},

    components: {
      Card
    },
  }

</script>

