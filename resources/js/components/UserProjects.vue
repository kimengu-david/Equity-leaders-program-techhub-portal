
<style>
.widget-user-header .text-white {
  background-position: center center;
  background-size: cover;
  height: 300px;
}
</style>
<template>
  <div class="container">
    <div class="row justify">
      <!--start of tabs.-->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  href="#ongoingprojects"
                  data-toggle="tab"
                >Ongoing Projects</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#myprojects" data-toggle="tab">Your Projects</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="ongoingprojects">
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Project ID</th>
                        <th>Project_name</th>
                        <th>Project_details</th>
                        <th>Project lead</th>
                        <th>Timeframe</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="project in projects" :key="project.id">
                        <td>{{project.id}}</td>
                        <td>{{project.project_name}}</td>
                        <td>{{project.project_details}}</td>
                        <td>{{project.project_lead}}</td>
                        <td>{{project.timeframe}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="myprojects">
                <!-- The timeline -->

                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Project ID</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="project in myprojects" :key="project.projects_id">
                        <td>{{project.projects_id}}</td>

                        <td>
                          <a href="#" @click="leaveProject(project.projects_id)">
                            <i class="fa fa-trash red"></i>
                            delete and leave
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!--End tabs-->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      hover: false,
      status: "false",
      editmode: false,
      meetups: {},
      projects: {},
      myprojects: {},
      form: new Form({
        id: "",
        Venue: "",
        Agenda: "",
        Date: "",
        Time: "",
        organizer: ""
      }),
      form2: new Form({
        organizer: ""
      })
    };
  },
  methods: {
    loadProjects() {
      axios.get("api/projects").then(({ data }) => (this.projects = data));
    },
    loadmyProjects() {
      axios.get("api/myprojects").then(({ data }) => (this.myprojects = data));
    },

    leaveProject(id, callback) {
      Swal.fire({
        title: "Are you sure?",
        text: "Click Okay only if you are sure to leave the project!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, I am sure!"
      }).then(result => {
        if (result.value) {
          axios
            .post("api/leaveProject/" + id)
            .then(({ data }) => {
              this.loadmyProjects();

              Swal.fire(
                "Success!",
                "You have successfully left the project.",
                "success"
              );
            })
            .catch(() => {
              Swal.fire("Failed!", "There was something wrong", "warning");
            });
        }
      });
    }
  },

  created() {
    this.loadProjects();
    this.loadmyProjects();
    //The below method sends http request every 3 seconds.
    //setInterval(() => this.loadUsers(), 3000);
    Fire.$on("AfterCreate", () => {
      this.loadMeetups();
      this.loadProjects();
    });
  }
};
</script>
