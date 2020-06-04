


<template>
  <div class="container">
    <!--The v-if method will only display if the authenticated user is an admin-->
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Techhub Group posts.</h3>

            <div class="card-tools">
              <button
                class="btn btn-success"
                @click="newModal()"
                data-toggle="modal"
                data-target="#addNew"
              >
                Create a post
                <i class="fas fa-camera"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Post ID</th>
                  <th>Caption</th>
                  <th>Image</th>
                  <th>created on</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="post in posts" :key="post.id">
                  <td>{{post.id}}</td>
                  <td>{{post.caption}}</td>
                  <td>{{post.image}}</td>

                  <td>{{post.created_at|myDate}}</td>

                  <td>
                    <a href="#" @click="editModal(user)">
                      <i class="fa fa-edit blue"></i>
                    </a>
                    /
                    <a href="#" @click="deletePost(post.id)">
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New Post</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--The .prevent prevents the page from refreshing-->
          <form
            @submit.prevent="editmode? updateUser() :createPost()"
            enctype="multipart/form-data"
          >
            <div class="modal-body">
              <div class="form-group id=myform">
                <label for="caption" class="col-md-4 col-form-label">post caption</label>

                <input
                  v-model="form.caption"
                  type="textarea"
                  name="caption"
                  placeholder="Enter caption here."
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('caption') }"
                />
                <!-- <textarea name="caption" form="myform">Enter text here...</textarea>
                <has-error :form="form" field="name"></has-error>-->
              </div>
              <div class="form-group">
                <label for="image" class="col-md-4 col-form-label">Post Image</label>
                <input
                  type="file"
                  name="image"
                  @change="setImage"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('image') }"
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
      posts: {},
      form: new Form({
        id: "",
        caption: "",
        image: "",
        created_at: ""
      })
    };
  },
  methods: {
    getResults(page = 1) {
      axios.get("api/post?page=" + page).then(response => {
        this.posts = response.data;
      });
    },
    setImage(e) {
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
    deletePost(id) {
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
            .delete("post/" + id)
            .then(() => {
              Swal.fire("Deleted!", "user deleted.", "success");
            })
            .catch(() => {
              Swal.fire("Failed!", "There was something wrong", "warning");
            });
        }
      });
    },
    loadPosts() {
      axios.get("api/post").then(({ data }) => (this.posts = data));
    },
    createPost(e) {
      this.$Progress.start();
      this.form
        .post("/post")
        .then(() => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Post created successfully"
          });
          this.$Progress.finish();
        })
        .catch(() => {});
    }
  },
  created() {
    this.loadPosts();
    //The below method sends http request every 3 seconds.
    //setInterval(() => this.loadUsers(), 3000);
    Fire.$on("AfterCreate", () => {
      this.loadPosts();
    });
  }
};
</script>
