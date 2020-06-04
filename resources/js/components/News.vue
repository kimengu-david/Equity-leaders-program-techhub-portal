
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
                <a class="nav-link active" href="#Meetups" data-toggle="tab">Meetups</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#projects" data-toggle="tab">Projects</a>
              </li>
            </ul>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="Meetups">
                <!-- Post -->
                <div v-for="meetup in meetups" :key="meetup.id" class="post">
                  <div class="user-block">
                    <img
                      src="/images/logo/logo.png"
                      alt="techhub logo"
                      class="brand-image img-circle elevation-3"
                      style="opacity: .8"
                    />
                    <span class="username">
                      <b style="color:blue">The ELP techhub team</b>
                      <a href="#" class="float-right btn-tool">
                        <i class="fas fa-times"></i>
                      </a>
                    </span>
                    <span class="description">
                      Posted
                      <b>{{checkWhenPosted(meetup.created_at)}}</b>
                    </span>
                  </div>
                  <!-- /.user-block -->
                  <p>
                    The ELP techhub team invites you to a meeting on
                    <b>{{meetup.Agenda}}</b> scheduled to
                    take place at
                    <b>{{meetup.Venue}}.</b> From
                    <b>{{meetup.Time}}</b>

                    <br />

                    <i>{{meetup.additionalInfo}}</i>
                    <br />
                    <br />
                    <b>registration deadline</b>

                    <b style="color:red">{{showDeadline(meetup.regdeadline)}}</b>
                    <b>remaining</b>

                    <br />
                  </p>

                  <p>
                    <a
                      v-if="showDeadline(meetup.regdeadline)<=0"
                      @click="meetingexpired()"
                      href="#"
                      class="btn btn-danger btn-sm"
                    >Registation closed</a>

                    <a
                      v-else
                      @click="attendMeetup(meetup.id)"
                      href="#"
                      class="btn btn-primary btn-sm"
                    >Click here to register</a>
                  </p>
                </div>

                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="projects">
                <!-- The timeline -->
                <div
                  v-for="project in projects"
                  :key="project.id"
                  class="timeline timeline-inverse"
                >
                  <!-- timeline item -->
                  <div>
                    <img
                      src="/images/logo/logo.png"
                      alt="techhub logo"
                      class="brand-image img-circle elevation-3"
                      style="opacity: .8"
                    />

                    <div class="timeline-item">
                      <span class="time">
                        <i class="fas fa-clock blue"></i>
                        {{project.created_at}}
                      </span>

                      <h3 class="timeline-header">
                        <b style="color:blue">ELP techhub project leads</b> posted a project
                      </h3>

                      <div class="timeline-body">
                        You can join the project
                        <b>{{project.project_name}}</b>. This project Runs
                        from
                        <b>{{project.timeframe}}.</b>
                        <br />
                        <br />
                        <b>project lead: {{project.project_lead}}</b>
                        <br />
                        <br />
                        <i>{{project.project_details}}</i>
                      </div>
                      <div class="timeline-footer">
                        <a
                          @click="joinProject(project.id)"
                          href="#"
                          class="btn btn-primary btn-sm"
                        >join the team</a>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
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
    showDeadline(fdate) {
      var fdate = moment(fdate);

      var eventTime = fdate;
      var currentTime = moment().tz("Africa/Nairobi");
      var duration;
      var interval, intervalId;

      interval = 60000; // 1 second

      // get time element

      duration = moment.duration(eventTime.diff(currentTime));

      // loop to countdown every 1 second
      //setInterval(function() {
      // get updated duration
      duration = moment.duration(duration, "milliseconds");

      if (duration.asSeconds() >= 0) {
        var mdeadline =
          duration.months() +
          " months " +
          duration.days() +
          " days " +
          duration.hours() +
          " hours ";
        return mdeadline;
      } else {
        return 0;
      }
    },
    /* // if duration is >= 0
        if (duration.asSeconds() <= 0) {
          clearInterval(intervalId);
          // hide the countdown element
          return "deadline reached";
        } else {
          var mdeadline =
            duration.months() +
            " months " +
            duration.days() +
            " days " +
            duration.hours() +
            " hours " +
            duration.minutes() +
            " minutes ";
          //duration.seconds() +
          return mdeadline;
          //" seconds";
          // console.log(deadline);
        }
      }, interval);
    },*/
    checkWhenPosted(finaldate) {
      var fdate = moment(finaldate); //.subtract(1, "M");
      // console.log(a.diff(b, "days"));
      //console.log(
      // moment()
      //.tz("Africa/Nairobi")
      //.format("YYYY MM DD hh:mm:ss")
      var remaining = moment(fdate, "YYYYMMDDSS").fromNow();

      //console.log(a.diff(b, "days")); // 1
      return remaining;
      // console.log(moment(b, "YYYYMMDD").fromNow());
    },
    regdeadline(regdeadline) {
      var fdate = moment(regdeadline);
      moment()
        .endOf("day")
        .fromNow(); // in 12 hours
    },
    loadMeetups() {
      axios.get("api/meetups").then(({ data }) => (this.meetups = data));
    },
    loadProjects() {
      axios.get("api/projects").then(({ data }) => (this.projects = data));
    },
    meetingexpired() {
      Swal.fire(
        "Meeting expired!",
        "You can not register for this meeeting",
        "warning"
      );
    },
    attendMeetup(id, callback) {
      Swal.fire({
        title: "Are you sure?",
        text: "Click Okay only if you are sure to attend!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, I am sure!"
      }).then(result => {
        if (result.value) {
          axios.post("api/attendMeetup/" + id).then(({ data }) => {
            if (data["message"] == "true") {
              Swal.fire(
                "Action not possible!",
                "You have already registered for this meeting",
                "warning"
              );
            } else {
              Swal.fire(
                "Registered!",
                "You have successfully Registered",
                "success"
              );
            }
          });
        }
      });
    },
    joinProject(id, callback) {
      Swal.fire({
        title: "Are you sure?",
        text: "Click Okay only if you are sure to commit yourself!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, I am sure!"
      }).then(result => {
        if (result.value) {
          axios.post("api/joinProject/" + id).then(({ data }) => {
            if (data["message"] == "true") {
              Swal.fire(
                "Action not possible!",
                "You are already a participant of this project",
                "warning"
              );
            } else {
              Swal.fire(
                "Registered!",
                "You have successfuly joined the developers team",
                "success"
              );
            }
          });
        }
      });
    }
  },

  created() {
    this.checkWhenPosted();
    this.loadMeetups();
    this.loadProjects();
    //The below method sends http request every 3 seconds.
    //setInterval(() => this.loadUsers(), 3000);
    Fire.$on("AfterCreate", () => {
      this.loadMeetups();
      this.loadProjects();
    });
  }
};
</script>
