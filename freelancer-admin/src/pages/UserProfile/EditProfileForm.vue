<template>
  <card>
    <h4 slot="header" class="card-title">Edit Profile</h4>
    <form enctype="multipart/form-data">
      <div class="profile-pic">
          <div class="image-wrapper">
            <img v-if="imageUrl" :src="imageUrl" alt="Profile Image" class="profile-pic-img">
          </div>
        </div>
        <div>
            <label class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" v-on:change="onChange">
                Choose Image
                <input type="file" style="display: none;">
            </label>
        </div>
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
import axios from 'axios';
import axiosConfig from '../../axios.js';

export default {
  computed: {
    ...mapState({
      stateUser: (state) => state.user,
    }),
    imagePath() {
      return this.localUser && this.localUser.user_data ? '/img/faces/' + this.localUser.user_data.image : '';
    }
  },

  components: {
    Card,
  },
  data() {
    return {
      // user: this.$store.state.user,
      loading: true,
      imageUrl: '',
      localUser: {
        id: '',
        name: '',
        email: '',
        role: '',
        user_data: {
          company: '',
          first_name: '',
          last_name: '',
          address: '',
          city: '',
          country: '',
          postal_code: '',
          description: '',
          image: '',
        },

      },
    };
  },
  methods: {
    ...mapActions(['updateUserProfile']),
    onChange(e) {
      const image = e.target.files[0];
      this.localUser.user_data.image = image;
      this.imageUrl = URL.createObjectURL(image);
    },
    async updateProfile() {
      try {
        const config = {
          headers: {
            'content-type': 'multipart/form-data',
          },
        };
        const formData = new FormData();

        // Check if image exists before appending to formData
        if (this.localUser.user_data.image && typeof this.localUser.user_data.image !== "string") {
          formData.append('image', this.localUser.user_data.image);
        }

        formData.append('id', this.localUser.id);

        if (formData.has('image')) { // Only make image upload request if image is present
          const imageResponse = await axios.post(`${axiosConfig.baseURL}/image-upload`, formData, config);
          this.localUser.user_data.image = imageResponse.data.image;
          this.imageUrl = imageResponse.data.imageURL;
          this.$store.commit('setUser', { ...this.stateUser, user_data: { ...this.stateUser.user_data, image: imageResponse.data.imageURL } });
        }

        // Now update the rest of the profile
        const updatedUser = await this.$store.dispatch('updateUserProfile', this.localUser);
        this.localUser = { ...updatedUser };

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
    this.localUser.role = this.stateUser.role;
    if(this.stateUser.user_data && this.stateUser.user_data.image) {
      this.imageUrl = `${axiosConfig.imageBaseURL}/img/faces/${this.stateUser.user_data.image}`;

    }
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
          this.localUser.role = newUser.role;
          if(newUser.user_data && newUser.user_data.image) {
            // this.imageUrl =  `http://localhost:8000/img/faces/${this.stateUser.user_data.image}`;
            this.imageUrl = `${axiosConfig.imageBaseURL}/img/faces/${this.stateUser.user_data.image}`;

          }
        }
      },
      deep: true, // ensure watcher triggers for nested data changes
    },
  },
};
</script>


<style>
.profile-pic {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  overflow: hidden;
  border: 5px solid #FF6347;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto;
}

.profile-pic img {
  width: 100%;
  height: auto;
}

.button-wrapper {
  display: flex;
  justify-content: space-evenly;
  margin-top: 20px;
}

.img-btn, .img-btn1 {
  padding: 10px 20px;
  color: white;
  font-size: 0.9em;
  border: none;
  cursor: pointer;
}

.upload-btn {
  background-color: red;
}

.choose-btn {
  background-color: blue;
}

</style>
