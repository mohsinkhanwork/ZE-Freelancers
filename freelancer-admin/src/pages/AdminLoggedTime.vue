<template>
  <div class="p-6 bg-gray-100 space-y-6">

    <div v-if="!timerActive" class="space-y-4">
      <button @click="downloadExcelReport" class="mt-4 py-2 px-4 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-opacity-50">
        Generate Excel Report
      </button>
    </div>

    <div class="mb-6">
      <h2 v-if="currentUser" class="text-2xl font-bold text-gray-700">Time logs for: {{ currentUser.name }}</h2>
    </div>

    <!-- Logs Table -->
    <div class="overflow-x-auto mt-4 rounded-lg shadow">
      <table class="w-full border-collapse border-gray-300 min-w-max divide-y divide-gray-200">
        <thead class="bg-blue-600">
          <tr>
            <th class="border p-2 text-white">Start Time (UTC)</th>
            <th class="border p-2 text-white">End Time (UTC)</th>
            <th class="border p-2 text-white">Project description</th>
            <th class="border p-2 text-white">Hours Logged (UTC)</th>
            <th class="border p-2 text-white">Date Log Created</th>
            <th class="border p-2 text-white">Status</th>
            <th class="border p-2 text-white">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in logs" :key="log.id">
            <td class="border p-2 text-gray-700">{{ convertToLocalWithTimezone(log.start_time) }}</td>
            <td class="border p-2 text-gray-700">{{ convertToLocalWithTimezone(log.end_time) }}</td>
            <td class="border p-2 text-gray-700">{{ log.description }}</td>
            <td class="border p-2 text-gray-700">{{ log.duration }}</td>
            <td class="border p-2 text-gray-700">{{ formatDate(log.created_at) }}</td>
            <td>
              <div v-if="log.status === 'Pending'" class="bg-yellow-300 text-yellow-900 rounded-full px-3 py-1 text-xs font-semibold">
                Pending
              </div>
              <div v-if="log.status === 'Approved'" class="bg-green-300 text-green-900 rounded-full px-3 py-1 text-xs font-semibold">
                Approved
              </div>
              <div v-if="log.status === 'Not approved'" class="bg-red-300 text-red-900 rounded-full px-3 py-1 text-xs font-semibold">
                Disapproved
              </div>
            </td>
            <td class="space-x-2">
              <button @click="approveLog(log.id)" v-if="log.status === 'Pending'" class="py-1 px-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all duration-300 focus:outline-none">
                Approve
              </button>
              <button @click="disapproveLog(log.id)" v-if="log.status === 'Pending'" class="py-1 px-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-300 focus:outline-none">
                Disapprove
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>




<script>
import { mapActions, mapState } from 'vuex';
import axios from 'axios';
import axiosConfig from '../axios';

const week = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']; // Define the week array

function zeroPadding(num, digit) {
    var zero = '';
    for(var i = 0; i < digit; i++) {
        zero += '0';
    }
    return (zero + num).slice(-digit);
}


export default {
  data() {
  return {
      manualStartTime: "",
      currentUser: null,
      manualEndTime: "",
      description: "",
      time: '',
      date: '',
      errors: {
          description: null
      },
  };
},
created() {
  this.updateTime();
  setInterval(this.updateTime, 1000);
},
  computed: {
      timerActive() {
          return this.$store.state.timerActive;
      },

      ...mapState(['logs'])
  },
  async mounted() {
    const userId = this.$route.params.id;  // Get user ID from the route
    await this.fetchLogs(userId);  // Pass user ID to the action

    try {
        const response = await axios.get(`${axiosConfig.baseURL}/get-user/${userId}`);
        this.currentUser = response.data;
    } catch (error) {
        console.error("Error fetching user details:", error);
    }


  },
  methods: {
    ...mapActions(['fetchLogs']),
    async downloadExcelReport() {
        try {
            const userId = this.$route.params.id;
            const response = await axios.get(`${axiosConfig.baseURL}/export-excel/${userId}`, { responseType: 'blob' });
            const url = window.URL.createObjectURL(new Blob([response.data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'logs.xlsx'); //or any other format you want
            document.body.appendChild(link);
            link.click();
        } catch (error) {
            console.error('Error downloading the file', error);
        }
    },
    async approveLog(logId) {
    try {
        const userId = this.$route.params.id;
        const response = await axios.put(`${axiosConfig.baseURL}/timelogs/${logId}/approve`);
        if (response.data.success) {
            await this.fetchLogs(userId);
        } else {
            console.error(response.data.message);
        }
    } catch (error) {
        console.error('Error approving the log', error);
    }
},
async disapproveLog(logId) {
    try {
        const userId = this.$route.params.id;
        const response = await axios.put(`${axiosConfig.baseURL}/timelogs/${logId}/disapprove`);
        if (response.data.success) {
            await this.fetchLogs(userId);
        } else {
            console.error(response.data.message);
        }
    } catch (error) {
        console.error('Error disapproving the log', error);
    }
},
      updateTime() {
    const cd = new Date();
    this.time = zeroPadding(cd.getHours(), 2) + ':' + zeroPadding(cd.getMinutes(), 2) + ':' + zeroPadding(cd.getSeconds(), 2);
    this.date = zeroPadding(cd.getFullYear(), 4) + '-' + zeroPadding(cd.getMonth() + 1, 2) + '-' + zeroPadding(cd.getDate(), 2) + ' ' + week[cd.getDay()];
  },
      formatDate(value) {
    const date = new Date(value);
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'UTC' };
    return date.toLocaleDateString(undefined, options);
    },
    convertToUTC(localTime) {
        let date = new Date(`1970-01-01T${localTime}:00Z`);  // Using Z ensures we're creating a UTC date
        return date.toISOString().split('T')[1].substring(0, 8);
    },
    convertToLocalWithTimezone(time) {
    return `${time.substring(11, 19)}`;
  },

  }
}
</script>
