<template>
  <div v-if="loading">Loading...</div>
  <card v-else>
    <h4 slot="header" class="card-title">Add User</h4>
    <form>
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
        <div class="col-md-4">
          <base-input type="text"
                    label="First Name"
                    placeholder="First Name"
                    v-model="user.user_data.first_name">
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input type="text"
                    label="Last Name"
                    placeholder="Last Name"
                    v-model="user.user_data.last_name">
          </base-input>
        </div>
        <div class="col-md-4">
          <base-input type="text"
                    label="Password"
                    placeholder="Enter password"
                    v-model="user.password">
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
                      placeholder="describe the user here"
                      v-model="user.user_data.description">
              </textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <select class="form-control" v-model="user.role">
            <option disabled value="">Please assign role</option>
            <option v-for="role in roles" :key="role.id" :value="role.name">{{ role.name }}</option>
          </select>
        </div>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-info btn-fill float-right" @click.prevent="addNewUser" :disabled="loading">
          Add User
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
    data () {
      return {
        user: {
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
        }
      };
    },

    computed: {
      ...mapState(['loading', 'roles']),
    },
    created () {
      this.getAllRoles();
    },
    methods: {
      ...mapActions(['addNewUserToServer', 'getAllRoles']),
      async addNewUser() {
        try {
          await this.addNewUserToServer(this.user);
          alert('User added successfully');
        } catch (error) {
         alert('Error Adding user');
         console.error(error);
        }
      },
    },

    components: {
      Card
    },
  }

</script>
