<template>
  <div>
    <v-app-bar dark text dense color="grey-lighten">
      <v-toolbar dense>Permissions</v-toolbar>
      <v-divider class="mx-2" inset vertical></v-divider>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="700px">
        <template #activator="{ on }">
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
                  <v-text-field
                    v-model="editedItem.name"
                    label="Name"
                  ></v-text-field>
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
      <template #item.action="{ item }">
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
      { text: "Actions", value: "action", sortable: false },
    ],
    tableData: [],
    editedIndex: -1,
    allPermissions: [],
    editedItem: {
      name: "",
      created_at: "",
    },
    defaultItem: {
      name: "",
      created_at: "",
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      axios.get("/api/permissions").then((response) => {
        this.tableData = response.data;
        this.allPermissions = this.tableData;
      });
    },

    editItem(item) {
      this.editedIndex = this.tableData.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.tableData.indexOf(item);
      confirm("Are you sure you want to delete this item?") &&
        this.tableData.splice(index, 1);

      axios
        .delete("/api/permissions/" + item.id)
        .then((response) => console.log(response.data));
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
          .put("/api/permissions/" + this.editedItem.id, this.editedItem)
          .then((response) => console.log(response.data));
      } else {
        this.tableData.push(this.editedItem);

        axios
          .post("/api/permissions/", this.editedItem)
          .then((response) => console.log(response.data));
      }
      this.close();
    },
  },
};
</script>
