<template>
  <div>
    <v-app-bar dark text color="grey-lighten" dense>
      <v-toolbar dense>Users</v-toolbar>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="700px">
        <template v-slot:activator="{ on }">
          <v-icon v-on="on">mdi-plus</v-icon>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field v-model="editedItem.name" label="Name"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field v-model="editedItem.email" label="Email"></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field v-model="editedItem.password" label="password"></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field v-model="editedItem.confirm_password" label="Confirm Password"></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <h3>Roles</h3>
                  <v-select
                    v-model="editedItem.role"
                    :items="allRoles"
                    label="Roles"
                    item-text="name"
                    return-object
                    chips
                  ></v-select>
                </v-flex>

                <v-flex xs12>
                  <v-select
                    v-model="editedItem.permissions"
                    :items="allPermissions"
                    label="Permissions"
                    item-text="name"
                    return-object
                    multiple
                    chips
                  ></v-select>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-app-bar>
    <v-data-table :headers="headers" :items="tableData" class="elevation-1">
      <template v-slot:item.action="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">edit</v-icon>
        <v-icon small @click="deleteItem(item)">delete</v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    headers: [
      { text: "Username", value: "name" },
      { text: "Email", value: "email" },
      { text: "Role", value: "role.name" },
      { text: "Actions", value: "action", sortable: false }
    ],
    tableData: [],
    editedIndex: -1,
    allRoles: [],
    allPermissions: [],
    editedItem: {
      name: "",
      email: "",
      role: {},
      permissions: [],
      created_at: ""
    },
    defaultItem: {
      name: "",
      email: "",
      role: {},
      permissions: [],
      created_at: ""
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      axios.get("/api/users").then(response => {
        this.tableData = response.data;
      });
      axios.get("/api/roles").then(response => (this.allRoles = response.data));
      axios
        .get("/api/permissions")
        .then(response => (this.allPermissions = response.data));
    },

    editItem(item) {
      this.editedIndex = this.tableData.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.tableData.indexOf(item);
      confirm("Você deseja apagar este item?") &&
        this.tableData.splice(index, 1);

      axios
        .delete("/api/users/" + item.id)
        .then(response => console.log(response.data));
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.tableData[this.editedIndex], this.editedItem);

        axios
          .put("/api/users/" + this.editedItem.id, this.editedItem)
          .then(response => console.log(response.data));
      } else {
        this.tableData.push(this.editedItem);

        axios
          .post("/api/users/", this.editedItem)
          .then(response => console.log(response.data));
      }
      this.close();
    }
  }
};
</script>
