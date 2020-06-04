


<template>
  <div class="container">
    <!--The v-if method will only display if the authenticated user is an admin-->
    <div class="row mt-5">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <b>
                Total Available funds
                <span style="color:red">Ksh.{{total}}</span>
              </b>
            </h3>

            <div class="card-tools">
              <button
                class="btn btn-success"
                @click="newModal()"
                data-toggle="modal"
                data-target="#addNew"
              >
                Post a transaction
                <i class="fas fa-money-check-alt"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>User_id</th>
                  <th>Account balance</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="twallet in twallets" :key="twallet.user_id">
                  <td>{{twallet.user_id}}</td>
                  <!--<td>{{user.fname}}</td>
                  <td>{{user.lname}}</td>-->
                  <td>{{twallet.balance}}</td>

                  <!--<td>{{user.created_at|myDate}}</td>-->
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <!-- <pagination :data="twallets" @pagination-change-page="getResults"></pagination>-->
          </div>
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
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Post a transaction</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!--The .prevent prevents the page from refreshing-->
          <form @submit.prevent="editmode? postTransaction() :postTransaction()">
            <div class="modal-body">
              <div class="form-group">
                <label for="organizer">User ID:</label>
                <input
                  v-model="form.user_id"
                  type="text"
                  name="user_id"
                  placeholder="user_id"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('user_id') }"
                />
                <has-error :form="form" field="user_id"></has-error>
              </div>
              <div class="form-group">
                <label for="organizer">Transaction Amount:</label>
                <input
                  v-model="form.amount"
                  type="text"
                  name="amount"
                  placeholder="Transaction amount"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('amount') }"
                />
                <has-error :form="form" field="amount"></has-error>
              </div>
              <div class="form-group">
                <label for="transactiondetails">Transaction Details</label>
                <input
                  v-model="form.transaction_details"
                  type="text"
                  name="transaction_details"
                  placeholder="transaction_details"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('transaction_details') }"
                />
                <has-error :form="form" field="transaction_details"></has-error>
              </div>

              <div class="form-group">
                <label for="organizer">Transaction Type:</label>
                <select
                  v-model="form.type"
                  name="type"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('type') }"
                >
                  <option value>Transaction type</option>
                  <option value="Debit">Debit(-)</option>
                  <option value="Credit">Credit(+)</option>
                </select>
                <has-error :form="form" field="role"></has-error>
              </div>

              <div class="form-group">
                <b>Posted_by</b>
                <input
                  v-model="form.fname"
                  readonly
                  type="text"
                  name="posted_by"
                  class="form-control"
                  :class="{ 'is-invalid': form.errors.has('posted_by') }"
                />
                <has-error :form="form" field="posted_by"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Post</button>
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
      form: new Form({
        user_id: "",
        fname: "",
        lname: "",
        amount: "",
        type: "",
        transaction_details: "",
        posted_by: ""
      }),
      twallets: {},
      total: {},
      editmode: false
    };
  },

  methods: {
    fetchTotal() {
      this.error = this.post = null;
      this.loading = true;

      axios.get("api/fetchTotal").then(response => {
        this.total = response.data;
      });
    },
    getResults(page = 1) {
      axios.get("api/twallet?page=" + page).then(response => {
        this.twallets = response.data;
      });
    },
    updateTwallet() {
      this.$Progress.start();
      //The below method was initially used for testing.
      //console.log("Editing data");
      this.form
        .put("api/twallet/" + this.form.user_id)
        .then(() => {
          //if it was successful
          $("#addNew").modal("hide");
          Swal.fire("Posted!", "user info updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    /*editModal(user) {
      this.editmode = true;
      this.form.reset();
      $("#addNew").modal("show");
      this.form.fill(user);
    },*/
    //Getting the authenticated user

    newModal() {
      this.editmode = false;
      this.form["user_id"] = "";
      this.form["amount"] = "";
      this.form["transaction_details"] = "";
      $("#addNew").modal("show");
    },

    loadTwallets() {
      axios.get("api/twallet").then(({ data }) => (this.twallets = data));
    },
    postTransaction() {
      this.$Progress.start();
      this.form
        .post("api/twallet") //+ this.form.id)
        .then(() => {
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");
          Toast.fire({
            icon: "success",
            title: "Transaction posted successfully"
          });
          this.$Progress.finish();
          this.fetchTotal();
        })
        .catch(() => {
          $("#addNew").modal("hide");

          Swal.fire("Failed!", "Check details and try again", "warning");
        });
    }
  },
  created() {
    axios
      .get("api/profile")
      .then(
        ({ data }) =>
          (this.form.fname = data["fname"].concat(" ", data["lname"]))
      ),
      this.loadTwallets();
    this.fetchTotal();

    //The below method sends http request every 3 seconds.
    //setInterval(() => this.loadUsers(), 3000);
    Fire.$on("AfterCreate", () => {
      this.loadTwallets();
    });
  }
};
</script>
