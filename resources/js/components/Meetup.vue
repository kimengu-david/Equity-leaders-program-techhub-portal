


<template>
  <div class="container">
    <!--The v-if method will only display if the authenticated user is an admin-->
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">ELP techhub meetups management</h3>

            <div class="card-tools">
              <button
                class="btn btn-success"
                @click="newModal()"
                data-toggle="modal"
                data-target="#addNew"
              >
                Create a meetup
                <i class="fab fa-meetup"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Venue</th>

                  <th>Attendees</th>
                  <th>Agenda</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Regdline</th>
                  <th>Organizer</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="meetup in meetups" :key="meetup.id">
                  <td>{{meetup.id}}</td>
                  <td>{{meetup.Venue}}</td>
                  <td>
                    <button class="btn btn-info" @click="generateAttendeesPdf(meetup.id)">
                      download
                      <i class="fas fa-download"></i>
                      <i class="fas fa-file-pdf"></i>
                    </button>
                  </td>
                  <td>{{meetup.Agenda}}</td>
                  <td>{{meetup.Date}}</td>

                  <td>{{meetup.Time}}</td>
                  <td>{{meetup.regdeadline}}</td>
                  <td>{{meetup.organizer}}</td>

                  <td>
                    <a href="#" @click="editModal(meetup)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deleteMeetup(meetup.id)">
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Create a New Meetup</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Meetup information</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--The .prevent prevents the page from refreshing-->
          <form
            @submit.prevent="editmode? updateMeetup() :createMeetup()"
            enctype="multipart/form-data"
          >
            <div class="modal-body">
              <div class="form-group id=myform">
                <label for="Venue">Venue:</label>
                <input
                  v-model="form.Venue"
                  name="caption"
                  placeholder="Enter venue here."
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('venue') }"
                />
              </div>
              <div class="form-group id=myform">
                <label for="agenda">Agenda:</label>
                <input
                  v-model="form.Agenda"
                  name="agenda"
                  placeholder="Enter The meeting agenda here"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('agenda') }"
                />
              </div>
              <div class="form-group id=myform">
                <label for="date">Date:</label>
                <input
                  v-model="form.Date"
                  type="date"
                  id="date"
                  name="date"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('date') }"
                />
              </div>
              <div class="form-group id=myform">
                <label for="Time">Time:</label>
                <input
                  v-model="form.Time"
                  name="Time"
                  placeholder="eg 9AM-10AM"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('Time') }"
                />
              </div>

              <div class="form-group id=myform">
                <label for="reg-deadline">Registration-deadline:</label>
                <input
                  v-model="form.regdeadline"
                  name="regdeadline"
                  type="datetime-local"
                  placeholder="eg 05/28/2020, 11:58 AM  (kindly stick to this format)"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('regdeadline') }"
                />
              </div>

              <div class="form-group id=myform">
                <label for="Time">Additionnal Info:</label>
                <input
                  v-model="form.additionalInfo"
                  name="additionalInfo"
                  placeholder="eg Please observe time, carry a book and a pen"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('additionalInfo') }"
                />
              </div>

              <div class="form-group id=myform">
                <label for="organizer">Meeting Organizer:</label>

                <input
                  v-if="editmode"
                  v-model="form.organizer"
                  readonly
                  name="organizer"
                  placeholder="Meeting organizer"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('organizer') }"
                />
                <input
                  v-if="!editmode"
                  v-model="form2.organizer"
                  readonly
                  name="organizer"
                  placeholder="Meeting organizer"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('organizer') }"
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
      pdf: "",
      meetups: {},
      form: new Form({
        id: "",
        Venue: "",
        Agenda: "",
        regdeadline: "",
        additionalInfo: "",
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
    getResults(page = 1) {
      axios.get("api/meetups?page=" + page).then(response => {
        this.meetups = response.data;
      });
    },
    generateAttendeesPdf(id) {
      axios
        .get("api/meetupAttendees/" + id)
        .then(({ data }) => (this.pdf = data))
        .then(() => {
          var byteCharacters = atob(this.pdf);
          var byteNumbers = new Array(byteCharacters.length);
          for (var i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
          }
          var byteArray = new Uint8Array(byteNumbers);
          var blob = new Blob([byteArray], { type: "application/pdf" });

          FileSaver.saveAs(blob, "Attendees.pdf");
          Swal.fire("Done!", "Attendees list downloaded", "success");
        })
        .catch(() => {
          Swal.fire(
            "Oops!",
            "No users have registered for this meetup",
            "warning"
          );
        });
    },

    updateMeetup() {
      this.$Progress.start();
      //The below method was initially used for testing.
      //console.log("Editing data");
      this.form
        .put("api/meetup/" + this.form.id)
        .then(() => {
          //if it was successful
          $("#addNew").modal("hide");
          Swal.fire("Updated!", "user info updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
          Swal.fire("Failed!", "There was something wrong", "warning");
        });
    },
    editModal(meetup) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(meetup);
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      this.form["organizer"] = this.form2["organizer"];
      $("#addNew").modal("show");
    },
    deleteMeetup(id) {
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
            .delete("api/meetup/" + id)
            .then(() => {
              Swal.fire("Deleted!", "Meetup deleted.", "success");
            })
            .catch(() => {
              Swal.fire("Failed!", "There was something wrong", "warning");
            });
        }
      });
    },
    loadMeetups() {
      axios.get("api/meetups").then(({ data }) => (this.meetups = data));
    },
    createMeetup() {
      this.$Progress.start();
      this.form
        .post("api/createMeetup")
        .then(() => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Meetup created successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {});
    }
  },
  created() {
    axios
      .get("api/profile")
      .then(
        ({ data }) =>
          (this.form2.organizer = data["fname"].concat(" ", data["lname"]))
      ),
      this.loadMeetups();
    //The below method sends http request every 3 seconds.
    //setInterval(() => this.loadUsers(), 3000);
    Fire.$on("AfterCreate", () => {
      this.loadMeetups();
    });
  }
};
</script>
