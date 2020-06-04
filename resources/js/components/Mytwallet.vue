
<style scoped>
/**
 * Demo Styles
 */

.circle {
  position: relative;
  display: block;
  margin: 2em 0;
  background-color: transparent;
  color: #222;
  text-align: center;
}

.circle:after {
  display: block;
  padding-bottom: 50%;

  width: 100%;
  height: 0;
  border-radius: 50%;
  background-color: #ddd;
  content: "";
}

.circle__inner {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.circle__wrapper {
  display: table;
  width: 100%;
  height: 100%;
}

.circle__content {
  display: table-cell;
  padding: 1em;
  vertical-align: middle;
}

@media (min-width: 480px) {
  .circle__content {
    font-size: 2em;
  }
}

@media (min-width: 768px) {
  .circle__content {
    font-size: 4em;
  }
}
</style>
<template>
  <div class="container">
    <div class="circle">
      <div class="circle__inner">
        <div class="circle__wrapper">
          <div class="circle__content">
            <div v-if="twallet.balance" class="inner">
              <b>
                <p>Available Balance</p>
              </b>
              <h3 style="color:green">Ksh.{{twallet.balance}}</h3>
            </div>
            <div v-if="!twallet.balance" class="inner">
              <b>
                <p>Available Balance</p>
              </b>
              <h2
                data-toggle="tooltip"
                data-placement="top"
                title="Pay your full membership fund, a minimum of ksh 500, to enjoy full membership"
              >Ksh.0.00</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <center>
        <button class="btn btn-info" @click="generateStatementPdf(twallet.user_id)">
          download statement
          <i class="fas fa-download"></i>
          <i class="fas fa-file-pdf"></i>
        </button>
      </center>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      twallet: {}
    };
  },

  mounted() {
    //console.log(this.$user->Id);
  },
  methods: {
    generateStatementPdf(id) {
      axios
        .get("api/generateStatement/" + id)
        .then(({ data }) => (this.pdf = data))
        .then(() => {
          var byteCharacters = atob(this.pdf);
          var byteNumbers = new Array(byteCharacters.length);
          for (var i = 0; i < byteCharacters.length; i++) {
            byteNumbers[i] = byteCharacters.charCodeAt(i);
          }
          var byteArray = new Uint8Array(byteNumbers);
          var blob = new Blob([byteArray], { type: "application/pdf" });

          FileSaver.saveAs(blob, "statement.pdf");
          Swal.fire("Done!", "Statement downloaded", "success");
        })
        .catch(() => {
          Swal.fire("Oops!", "You have no transactions recorded", "info");
        });
    },
    fetchTwallet() {
      this.error = this.post = null;
      this.loading = true;

      axios.get("api/showtwallet").then(response => {
        this.twallet = response.data;
      });
    }
  },
  created() {
    this.fetchTwallet();
  }
};
</script>
