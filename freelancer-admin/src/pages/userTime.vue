<template>
  <div class="p-6 bg-gray-50 space-y-6">
    <!-- Manual Log Entry -->
    <div class="flex justify-center items-center">
      <div class="clock-container p-6 rounded-lg shadow-md bg-gradient-to-br from-blue-600 to-blue-800 text-white">
        <p class="text-2xl font-semibold mb-2">Current Time</p>
        <p class="text-4xl font-bold mb-2">{{ time }}</p>
        <p class="text-lg">{{ date }}</p>
      </div>
    </div>
    <div v-if="!timerActive" class="space-y-4">
      <div class="text-xl font-bold mb-2 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <!-- Sample icon, you can replace with any relevant icon -->
          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 6h18M3 12h18m-6 6H9" />
        </svg>
        Manual Entry
      </div>
      <div class="grid grid-cols-2 gap-4">
          <input type="time" v-model="manualStartTime" class="p-2 border rounded" placeholder="Start Time">
          <input type="time" v-model="manualEndTime" class="p-2 border rounded" placeholder="End Time">
      </div>
      <textarea v-model="description" class="w-full p-2 border rounded mt-2" rows="4" placeholder="Describe your project..."></textarea>
      <div v-if="errors.description" class="text-red-500 mt-2">
        {{ errors.description }}
      </div>
      <button @click="saveManualLog" class="mt-4 py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600 transition-all duration-300">Log Time</button>
    </div>

    <!-- Logs Table -->
    <div class="overflow-x-auto mt-4">
      <table class="w-full border-collapse border min-w-max">
        <thead>
            <tr>
                <th class="border p-2 bg-blue-50">Start Time (UTC)</th>
                <th class="border p-2 bg-blue-50">End Time (UTC)</th>
                <th class="border p-2 bg-blue-50">Project description</th>
                <th class="border p-2 bg-blue-50">Hours Logged (UTC)</th>
                <th class="border p-2 bg-blue-50">Date Log Created</th>
                <th class="border p-2 bg-blue-50">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="log in logs" :key="log.id">
              <td class="border p-2">{{ convertToLocalWithTimezone(log.start_time) }}</td>
              <td class="border p-2">{{ convertToLocalWithTimezone(log.end_time) }}</td>
              <td class="border p-2">{{ log.description }}</td>
              <td class="border p-2">{{ log.duration }}</td>
              <td class="border p-2">{{ formatDate(log.created_at) }}</td>
              <td class="border p-2" :class="statusClass(log.status)">{{ log.status }}</td>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>



<script>
import { mapActions } from 'vuex';
import { mapState } from 'vuex';

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
    console.log("Component mounted");
    await this.fetchLogs();
    console.log("Fetched Logs:", this.logs);
    console.log("Raw Start Time:", this.logs.map(log => log.start_time));
    console.log("Raw End Time:", this.logs.map(log => log.end_time));
},
  methods: {
    ...mapActions(['startTimer', 'stopTimerAndLog', 'saveLog', 'fetchLogs']),

        statusClass(status) {
          switch (status) {
          case 'Pending':
            return 'bg-blue-200 text-blue-800';
          case 'Not approved':
            return 'bg-red-200 text-red-800';
          case 'approved':
            return 'bg-green-200 text-green-800';
          default:
            return 'bg-gray-200 text-gray-800';
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


    async saveManualLog() {
    if (this.manualEndTime < this.manualStartTime) {
        alert("End time should be after start time");
        return;
    }

    const utcStartTime = this.convertToUTC(this.manualStartTime);
    const utcEndTime = this.convertToUTC(this.manualEndTime);

    const logData = {
        start_time: `${utcStartTime}`,
        end_time: `${utcEndTime}`,
        description: this.description,
        user_id: this.$store.state.currentUser.id
    };
    try {
        await this.saveLog(logData);
        await this.fetchLogs();  // Fetch logs after successfully saving
        this.manualStartTime = "";
        this.manualEndTime = "";
        this.description = "";
        this.errors.description = null;
    } catch (e) {
        this.errors.description = e.message;  // Set the error message to the errors object
    }
}


  }
}
</script>
