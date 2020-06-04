


<template>
  <div class="container">
    <!--The v-if method will only display if the authenticated user is an admin-->
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">ELP techhub Projects management</h3>

            <div class="card-tools">
              <button
                class="btn btn-success"
                @click="newModal()"
                data-toggle="modal"
                data-target="#addNew"
              >
                Start a project
                <i class="fas fa-project-diagram"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Project_name</th>
                  <th>Project_details</th>
                  <th>Project lead</th>
                  <th>Timeframe</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="project in projects" :key="project.id">
                  <td>{{project.id}}</td>
                  <td>{{project.project_name}}</td>
                  <td>{{project.project_details}}</td>
                  <td>{{project.project_lead}}</td>
                  <td>{{project.timeframe}}</td>

                  <td>
                    <a href="#" @click="editModal(project)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteProject(project.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <!--<div class="card-footer">
            <pagination :data="posts" @pagination-change-page="getResults"></pagination>
          </div>-->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Create a New Project</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Project information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--The .prevent prevents the page from refreshing-->
          <form
            @submit.prevent="editmode? updateProject() :createProject()"
            enctype="multipart/form-data"
          >
            <div class="modal-body">
              <div class="form-group id=myform">
                <label for="project_name">Project Name:</label>
                <input
                  v-model="form.project_name"
                  name="project_name"
                  placeholder="eg wings to fly website"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('project_name') }"
                />
              </div>
              <div class="form-group id=myform">
                <label for="project_details">Project Details:</label>
                <input
                  v-model="form.project_details"
                  name="project_details"
                  placeholder="eg language used python, java"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('project_details') }"
                />
              </div>

              <div class="form-group id=myform">
                <label for="timeframe">TimeFrame:</label>
                <input
                  v-model="form.timeframe"
                  name="timeframe"
                  placeholder="eg june 2019 to Dec 2019"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('timeframe') }"
                />
              </div>

              <div class="form-group id=myform">
                <label for="project_lead">Project Lead:</label>

                <input
                  v-if="editmode"
                  v-model="form.project_lead"
                  readonly
                  name="project_lead"
                  placeholder="project lead"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('timeframe') }"
                />
                <input
                  v-if="!editmode"
                  v-model="form2.project_lead"
                  readonly
                  name="project_lead"
                  placeholder="project_lead"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('project_lead') }"
                />
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      editmode: false,
      projects: {},
      form: new Form({
        id: "",
        project_name: "",
        project_details: "",
        project_lead: "",
        timeframe: ""
      }),
      form2: new Form({
        project_lead: ""
      })
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/projects?page=" + page).then(response => {
        this.projects = response.data;
      });
    },

    updateProject() {
      this.$Progress.start();
      //The below method was initially used for testing.
      //console.log("Editing data");
      this.form
        .put("api/project/" + this.form.id)
        .then(() => {
          //if it was successful
          $("#addNew").modal("hide");
          Swal.fire("Updated!", "Project info updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
          Swal.fire("Failed!", "There was something wrong", "warning");
        });
    },
    editModal(project) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(project); 
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      this.form["project_lead"] = this.form2["project_lead"];
      $("#addNew").modal("show");
    },
    deleteProject(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //Send request to the server.
        if (result.value) {
          this.form
            .delete("api/project/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Project deleted.", "success");
            })
            .catch(() => {
              Swal.fire("Failed!", "There was something wrong", "warning");
            });
        }
      });
    },
    loadProjects() {
      axios.get("api/projects").then(({ data }) => (this.projects = data));
    },
    createProject() {
      this.$Progress.start();
      this.form
        .post("api/createProject")
        .then(() => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Project created successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {
          Swal.fire("Failed!", "There was something wrong", "warning");
        });
    }
  },
  created() {
    axios
      .get("api/profile")
      .then(
        ({ data }) =>
          (this.form2.project_lead = data["fname"].concat(" ", data["lname"]))
      ),
      this.loadProjects();
    //The below method sends http request every 3 seconds.
    //setInterval(() => this.loadUsers(), 3000);
    Fire.$on("AfterCreate", () => {
      this.loadProjects();
    });
  }
};
</script>
