<template>
  <div id="app">
    <v-app id="inspire" dark>
      <v-navigation-drawer v-model="drawer" clipped fixed app dark :width="260">
        <sidebar></sidebar>
      </v-navigation-drawer>

      <navbar :user="user" @comute-drawer="comuteDrawer"></navbar>

      <v-main>
        <v-container fluid fill-height>
          <v-layout justify-center>
            <v-flex>
              <router-view></router-view>
            </v-flex>
          </v-layout>
        </v-container>
      </v-main>
      <v-footer app fixed>
        <span>&copy; 2022</span>
      </v-footer>
    </v-app>
  </div>
</template>

<script>
import Sidebar from "./_sidebar";
import Navbar from "./_navbar";

export default {
  components: { Sidebar, Navbar },
  props: ["user"],
  data: () => ({
    drawer: null,
  }),
  methods: {
    comuteDrawer() {
      this.drawer = !this.drawer;
    },
  },
};
</script>
