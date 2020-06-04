


<template>
  <div class="container">
    <!--The v-if method will only display if the authenticated user is an admin-->
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Techhub Members</h3>

            <div class="card-tools">
              <button v-if="role=='admin'" class="btn btn-success" @click="createUser()">
                Add New
                <i class="fas fa-user-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>User ID</th>
                  <th>First_Name</th>
                  <th>Last_Name</th>
                  <th>Username</th>
                  <th v-if="role=='admin'">role</th>
                  <th>Gender</th>
                  <th v-if="role=='admin'">Membership_Status</th>
                  <th>Phone_Number</th>
                  <th>School</th>
                  <th>Course</th>
                  <th>Year</th>
                  <th>Linkedin_Link</th>
                  <th>Github_Link</th>

                  <th>Email</th>

                  <th v-if="role=='admin'">image</th>

                  <th>skills</th>
                  <th>Registered on</th>
                  <th v-if="role=='admin'">Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(user,index) in users.data" :key="user.id">
                  <td>{{index+1}}</td>
                  <td>{{user.id}}</td>
                  <td>{{user.fname}}</td>
                  <td>{{user.lname}}</td>
                  <td>{{user.username}}</td>
                  <td v-if="role=='admin'">{{user.role|upText}}</td>
                  <td>{{user.gender}}</td>
                  <td v-if="role=='admin'">{{user.membership_status}}</td>
                  <td>{{user.cont}}</td>
                  <td>{{user.school}}</td>
                  <td>{{user.course}}</td>
                  <td>{{user.year}}</td>
                  <td>{{user.linkedin}}</td>
                  <td>{{user.github}}</td>
                  <td>{{user.email}}</td>
                  <td v-if="role=='admin'">{{user.image}}</td>
                  <td>{{user.skills}}</td>
                  <td>{{user.created_at|myDate}}</td>

                  <td v-if="role=='admin'">
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteUser(user.id)">
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
            <div v-show="isvisible">
              <table id="mytable" class="table table-hover">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>First_Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Membership_Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(user,index) in users2.data" :key="user.id">
                    <td>{{index+1}}</td>
                    <td>{{user.fname}}</td>
                    <td>{{user.lname}}</td>
                    <td>{{user.gender}}</td>
                    <td>{{user.cont}}</td>
                    <td>{{user.membership_status}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div v-show="isvisible">
              <table id="myheaders" class="table table-hover">
                <thead>
                  <tr>
                    <th>ELP techhub members</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      Total members list as at
                      <b>{{getCurrentTime()}}</b>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="users" @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <div v-if="role=='admin'" class="col-md-3">
          <button class="btn btn-info" @click="downloadPdf()">
            Generate users pdf
            <i class="fas fa-download"></i>
            <i class="fas fa-file-pdf"></i>
          </button>
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Change Member Roles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--The .prevent prevents the page from refreshing-->
          <form @submit.prevent="editmode? updateUser() :createUser()">
            <div class="modal-body">
              <div class="form-group">
                <select
                  v-model="form.role"
                  name="role"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('role') }"
                >
                  <option value="user">Standard user</option>
                  <option value="admin">Administrator</option>

                  <option value="projectlead">Project lead</option>
                  <option value="treasurer">Treasurer</option>
                  <option value="secreatary">Secreatary</option>
                  <option value="mediacontroller">Media controller</option>
                </select>
                <has-error :form="form" field="role"></has-error>
              </div>
              <!--
              <div class="form-group">
                <input
                  v-model="form.password"
                  type="password"
                  name="password"
                  placeholder="password"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('password') }"
                />
                <has-error :form="form" field="password"></has-error>
              </div>-->
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
import * as jsPDF from "jspdf";
import "jspdf-autotable";
export default {
  data() {
    return {
      todos: [
        {
          title: "title1",
          description: "description1"
        },
        {
          title: "title2",
          description: "description2"
        },
        {
          title: "title3",
          description: "description3"
        }
      ],
      editmode: false,
      name: "pdf",
      isvisible: false,
      users: {},
      users2: {},
      usersArray: [],
      role: {},
      form: new Form({
        id: "",
        fname: "",
        lname: "",
        gender: "",
        membership_status: "",
        cont: "",
        school: "",
        course: "",
        year: "",
        github: "",
        linkedin: "",
        skills: "",
        email: "",
        username: "",
        role: "",
        password: ""
      })
    };
  },
  methods: {
    get1DArray(arr) {
      var result = new Array();

      for (var x = 0; x < arr.length; x++) {
        for (var y = 0; y < arr[x].length; y++) {
          result.push(arr[x][y]);
        }
      }

      return result;
    },

    rowCount() {
      var x = document.getElementsByTagName("tr");
      var txt = "";
      var i;
      for (i = 0; i < x.length; i++) {
        var rownumber = x[i].rowIndex;
      }
      return this.rownumber;
    },

    downloadPdf() {
      var doc = new jsPDF("p", "in", [612, 792]);
      // doc.addPageContent("ELP techhub members");

      doc.autoTable({
        theme: "plain",
        headStyles: { fontSize: 25, fontStyle: "bold", halign: "center" },
        styles: {
          fontStyle: "bolditalic"
        },

        html: "#myheaders"
      });

      doc.autoTable({
        /* styles: { fillColor: [255, 0, 0] },*/

        //columnStyles: { 0: { halign: "center", fillColor: [0, 255, 0] } }, // Cells in first column centered and green
        margin: { top: 1 }, //]

        /* body: [
          ["Sweden", "Japan", "Canada"],
          ["Norway", "China", "USA"],
          ["Denmark", "China", "Mexico"]*/

        html: "#mytable",
        includeHiddenHTML: true
      });

      doc.save("ELPtechhub members.pdf");
    },

    getResults(page = 1) {
      axios.get("api/user?page=" + page).then(response => {
        this.users = response.data;
      });
    },
    printUsers() {
      axios.get("api/printUsers").then(({ data }) => (this.users = data));
    },
    updateUser() {
      this.$Progress.start();
      //The below method was initially used for testing.
      //console.log("Editing data");
      this.form
        .put("api/user/" + this.form.id)
        .then(() => {
          //if it was successful
          $("#addNew").modal("hide");
          Swal.fire("Updated!", "user info updated.", "success");
          this.$Progress.finish();
          this.loadUsers();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    deleteUser(id) {
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
            .delete("api/user/" + id)
            .then(() => {
              Swal.fire("Deleted!", "user deleted.", "success");
            })
            .catch(() => {
              Swal.fire("Failed!", "There was something wrong", "warning");
            });
        }
      });
    },
    loadUsers() {
      axios.get("api/user").then(({ data }) => (this.users = data));
    },

    getCurrentTime() {
      return moment()
        .tz("Africa/Nairobi")
        .format("YYYY MM DD");
    },

    //For downloading users in form of pdf.
    downloadable() {
      axios.get("api/userdownload").then(({ data }) => (this.users2 = data));
    },
    createUser() {
      Swal.fire("Oops!", "Action not currently allowed", "warning");
    }
  },
  created() {
    axios.get("api/profile").then(({ data }) => (this.role = data["role"]));
    Fire.$on("searching", () => {
      let query = this.$parent.search;
      axios
        .get("api/findUser?q=" + query)
        .then(data => {
          this.users = data.data;
        })
        .catch(() => {});
    });
    this.loadUsers();
    this.downloadable();
    //The below method sends http request every 3 seconds.
    //setInterval(() => this.loadUsers(), 3000);
    Fire.$on("AfterCreate", () => {
      this.loadUsers();
    });
  }
};
</script>
