<template>
  <v-app-bar app fixed clipped-left dense color="indigo">
    <v-app-bar-nav-icon @click.stop="comuteDrawer"></v-app-bar-nav-icon>
    <v-toolbar-title class="mr-12 align-center"
      >Gestão de Condomínios</v-toolbar-title
    >
    <v-spacer></v-spacer>

    <!-- <v-menu
      offset-y
      origin="center center"
      class="elelvation-1"
      :nudge-bottom="14"
      transition="scale-transition"
    >
      <template v-slot:activator="{ on }">
        <v-btn v-on="on" @click="markAsRead" icon text>
          <v-badge color="red" overlap>
            <span slot="badge">
              {{
              unreadNotifications.length
              }}
            </span>
            <v-icon medium>notifications</v-icon>
          </v-badge>
        </v-btn>
      </template>

      <v-list>
        <v-list-item
          :class="{ green: notification.read_at == null }"
          @click="markAsRead"
          v-for="notification in allNotifications"
          :key="notification.id"
        >
          <v-list-item-content>
            <v-list-item-title>
              {{ notification.data.createdUser.name }} has just
              registered on
              {{ notification.created_at }}
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu> -->
    <v-menu
      offset-y
      origin="center center"
      :nudge-bottom="10"
      transition="scale-transition"
    >
      <template #activator="{ on }">
        <v-btn icon large text v-on="on">
          <v-avatar size="30px">
            <img src="https://via.placeholder.com/150" alt="Michael Wang" />
          </v-avatar>
        </v-btn>
      </template>
      <v-list class="pa-0">
        <v-list-item ripple="ripple" rel="noopener">
          <v-list-item-content>
            <v-list-item-title>{{ user.name }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-list class="pa-0">
        <v-list-item ripple="ripple" rel="noopener" @click="logout">
          <v-list-item-action>
            <v-icon>account_circle</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Logout</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
import axios from "axios";
export default {
  props: ["user"],
  data: () => ({
    drawer: null,
    allNotifications: [],
    unreadNotifications: [],
  }),
  watch: {
    allNotifications(val) {
      this.unreadNotifications = this.allNotifications.filter(
        (notification) => {
          return notification.read_at == null;
        }
      );
    },
  },

  created() {
    // this.allNotifications = this.user.notifications;
    // this.unreadNotifications = this.allNotifications.filter(
    //     notification => {
    //         return notification.read_at == null;
    //     }
    // );
    // Echo.private("App.User." + this.user.id).notification(notification => {
    //   this.allNotifications.unshift(notification.notification);
    // });
  },

  methods: {
    logout() {
      axios
        .post("/logout")
        .then((response) => (window.location.href = "/login"));
    },
    markAsRead() {
      // axios.get("/mark-all-read/" + this.user.id).then(response => {
      //     this.unreadNotifications = [];
      // });
    },
    comuteDrawer() {
      this.$emit("comute-drawer");
    },
  },
};
</script>
