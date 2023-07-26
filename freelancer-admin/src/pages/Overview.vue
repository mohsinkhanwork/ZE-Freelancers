<template>
  <div class="content">
    <div class="col-lg-12 position-relative z-index-2">
                      <div class="card card-plain mb-4">
                        <div class="card-body p-3">
                            <div class="row">
                              <div class="col-lg-6">
                                  <div class="d-flex flex-column h-100">
                                    <h2 class="font-weight-bolder mb-0">General Statistics</h2>
    </div>

            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-5 col-sm-5">
          <div class="card  mb-2">
    <div class="card-header p-3 pt-2">
      <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">weekend</i>
      </div>
      <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize">Pluse</p>
        <h4 class="mb-0">281</h4>
      </div>
    </div>

    <hr class="dark horizontal my-0">
    <div class="card-footer p-3">

    </div>
    </div>

          <div class="card  mb-2 mt-5">
    <div class="card-header p-3 pt-2">
      <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">leaderboard</i>
      </div>
      <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize">Absent</p>
        <h4 class="mb-0">2,300</h4>
      </div>
    </div>

    <hr class="dark horizontal my-0">
    <div class="card-footer p-3">

    </div>
    </div>

        <div class="card  mb-2 mt-5">
    <div class="card-header p-3 pt-2">
      <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">leaderboard</i>
      </div>
      <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize">Open Application</p>
        <h4 class="mb-0">2,300</h4>
      </div>
    </div>

    <hr class="dark horizontal my-0">
    <div class="card-footer p-3">

    </div>
    </div></div>

      <div class="col-lg-5 col-sm-5 mt-sm-0 mt-4">
          <div class="card  mb-2">
    <div class="card-header p-3 pt-2 bg-transparent">
      <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">store</i>
      </div>
      <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize ">Add Employee</p>
        <h4 class="mb-0 ">34k</h4>
      </div>
    </div>

    <hr class="horizontal my-0 dark">
    <div class="card-footer p-3">

    </div>
    </div>

          <div class="card mt-5 ">
    <div class="card-header p-3 pt-2 bg-transparent">
      <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">person_add</i>
      </div>
      <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize ">Live overview</p>
        <h4 class="mb-0 ">+91</h4>
      </div>
    </div>

    <hr class="horizontal my-0 dark">
    <div class="card-footer p-3">

    </div>
    </div>

        <div class="card mt-5 ">
    <div class="card-header p-3 pt-2 bg-transparent">
      <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">person_add</i>
      </div>
      <div class="text-end pt-1">
        <p class="text-sm mb-0 text-capitalize ">News</p>
        <h4 class="mb-0 ">+91</h4>
      </div>
    </div>

    <hr class="horizontal my-0 dark">
    <div class="card-footer p-3">

    </div>
      </div>
      </div>
    </div>



    </div>
  </div>
</template>
<script>
  import ChartCard from 'src/components/Cards/ChartCard.vue'
  import StatsCard from 'src/components/Cards/StatsCard.vue'
  import LTable from 'src/components/Table.vue'

  import { mapState } from 'vuex';


  export default {

    components: {
      LTable,
      ChartCard,
      StatsCard
    },
    data () {
      return {
        editTooltip: 'Edit Task',
        deleteTooltip: 'Remove',
        pieChart: {
          data: {
            labels: ['40%', '20%', '40%'],
            series: [40, 20, 40]
          }
        },
      }
    }
  }
</script>
