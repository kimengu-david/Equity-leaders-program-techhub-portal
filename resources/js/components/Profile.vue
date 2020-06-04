
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
      <div class="col-md-12">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div
            class="widget-user-header text-white"
            style="background: url('./images/coverimage.jpeg') center center;"
          >
            <h3 class="widget-user-username text-right">{{this.form.username}}</h3>
            <h5 class="widget-user-desc text-right">{{this.form.skills}}</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar" />
          </div>
          <div class="card-footer"></div>
        </div>
      </div>
      <!--start of tabs.-->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <!--<li class="nav-item">
                <a class="nav-link active" href="#activity" data-toggle="tab">Activity</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a>
              </li>-->
              <li class="nav-item">
                <a class="nav-link" href="#settings" data-toggle="tab">Profile settings</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form class="form-horizontal">
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        v-model="form.fname"
                        class="form-control"
                        id="inputName"
                        placeholder="First Name"
                        :class="{ 'is-invalid': form.errors.has('fname') }"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        v-model="form.lname"
                        class="form-control"
                        id="inputName"
                        placeholder="last Name"
                        :class="{ 'is-invalid': form.errors.has('lname') }"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        v-model="form.username"
                        class="form-control"
                        id="inputusername"
                        placeholder="UserName"
                        :class="{ 'is-invalid': form.errors.has('username') }"
                      />
                      <has-error :form="form" field="name"></has-error>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input
                        type="email"
                        v-model="form.email"
                        class="form-control"
                        id="inputEmail"
                        placeholder="Email"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                      />
                      <has-error :form="form" field="email"></has-error>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                    <div class="col-sm-10">
                      <input
                        type="file"
                        @change="updateProfile"
                        name="image"
                        class="form-input"
                        :class="{ 'is-invalid': form.errors.has('image') }"
                      />
                    </div>
                    <has-error :form="form" field="image"></has-error>
                  </div>

                  <div class="form-group row">
                    <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        v-model="form.skills"
                        class="form-control"
                        id="inputSkills"
                        placeholder="What best describes you eg java programmer"
                        :class="{ 'is-invalid': form.errors.has('skills') }"
                      />
                      <has-error :form="form" field="skills"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputgithub" class="col-sm-2 col-form-label">Github link</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        v-model="form.github"
                        class="form-control"
                        id="inputgithub"
                        placeholder="githublink"
                        :class="{ 'is-invalid': form.errors.has('github') }"
                      />
                      <has-error :form="form" field="github"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputlinkedin" class="col-sm-2 col-form-label">Linkedin link</label>
                    <div class="col-sm-10">
                      <input
                        type="text"
                        v-model="form.linkedin"
                        class="form-control"
                        id="inputlinkedin"
                        placeholder="linkedinlink"
                        :class="{ 'is-invalid': form.errors.has('linkedin') }"
                      />
                      <has-error :form="form" field="linkedin"></has-error>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" /> I agree to the
                          <a href="#">terms and conditions</a>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                      <button
                        @click.prevent="updateInfo"
                        type="submit"
                        class="btn btn-success"
                      >Update</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
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
      form: new Form({
        id: "",
        fname: "",
        lname: "",
        email: "",
        username: "",
        image: "",
        github: "",
        linkedin: "",
        skills: "",

        password: ""
      })
    };
  },
  mounted() {
    console.log("Component mounted.");
  },

  methods: {
    getProfilePhoto() {
      //The below method compares if the profile picture has been changed or not.
      let photo =
        this.form.image.length > 200
          ? this.form.image
          : "/images/profile/" + this.form.image;
      //return "/images/profile/" + this.form.image;
      console.log(this.form.image);
      return photo;
    },
    updateInfo() {
      this.$Progress.start();
      this.form
        .put("api/profile")
        .then(() => {
          //The fire after emit method provides the real time updating.
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
          Swal.fire("Updated!", "Profile updated.", "success");
        })
        .catch(() => {
          this.$Progress.fail();
          Swal.fire("Failed!", "Please check and try again", "warning");
        });
    },

    //The below method is fired when a user a user uploads an image.

    updateProfile(e) {
      let file = e.target.files[0];
      console.log(file);
      let reader = new FileReader();

      //The following code converts the image to base64.
      if (file["size"] < 2111775) {
        reader.onloadend = e => {
          //console.log("RESULT", reader.result);
          this.form.image = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        Swal.fire({
          type: "error",
          title: "Oops...",
          text: "The image file is too large!"
        });
      }
    }
  },
  created() {
    axios.get("api/profile").then(({ data }) => this.form.fill(data));
  }
};
</script>
