<template>
  <!--<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
  -->

  <div class="container">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <!-- /.col -->
          <div class="col-md-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="/">Home</a>
              </li>
              <li class="breadcrumb-item active">Techhub portal v1</li>
            </ol>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-8">
            <!-- small box -->
            <div class="small-box bg-info">
              <div v-if="twallet.balance" class="inner">
                <h3>Ksh.{{twallet.balance}}</h3>

                <p>Twallet Balance</p>
              </div>
              <div v-if="!twallet.balance" class="inner">
                <h3
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Pay your full membership fund, a minimum of ksh 500, to enjoy full membership"
                >Ksh.0.00</h3>

                <p>Twallet Balance</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">
                More info
                <i class="fas fa-arrow-circle-right"></i>
              </a>-->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-8">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{meetup}}</h3>

                <p>Meetup(s) Attended</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-8">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{project}}</h3>

                <p>Project(s) involved</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">
                More info
                <i class="fas fa-arrow-circle-right"></i>
              </a>-->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-8">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h5>Membership Status</h5>
                <div v-if="twallet.balance>=500">
                  <p color="black">Registered</p>
                </div>
                <div v-if="twallet.balance<500||!twallet.balance">
                  <p
                    data-toggle="tooltip"
                    data-placement="top"
                    title="To have full Membership and enjoy unlimited benefits your Twallet balance must be a minimum of Ksh.500"
                  >Pending approval</p>
                </div>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row (main row) -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  <!--
        <div class="card">
          <div class="card-header">Dashboard Component</div>

          <div class="card-body">I'm an example component.</div>
        </div>
        
      </div>
    </div>
  </div>-->
</template>

<script>
import { gmapApi } from "vue2-google-maps";
export default {
  data() {
    return {
      loading: false,
      twallet: {},

      user: {},

      error: null,
      meetup: null,
      project: null
    };
  },
  created() {
    // fetch the data when the view is created and the data is
    // already being observed
    this.fetchTwallet();
    this.fetchUser();
    this.fetchMeetup();
    this.fetchProject();
  },
  watch: {
    // call again the method if the route changes
    $route: "fetchData"
  },
  methods: {
    fetchTwallet() {
      this.error = this.post = null;
      this.loading = true;

      axios.get("api/showtwallet").then(response => {
        this.twallet = response.data;
      });
    },
    fetchUser() {
      this.error = this.post = null;
      this.loading = true;

      axios.get("api/profile").then(response => {
        this.user = response.data;
      });
    },
    fetchMeetup() {
      this.error = this.post = null;
      this.loading = true;

      axios.get("api/meetup").then(response => {
        this.meetup = response.data;
      });
    },
    fetchProject() {
      this.error = this.post = null;
      this.loading = true;

      axios.get("api/userProjects").then(response => {
        this.project = response.data;
      });
    }
  }
};
</script>


