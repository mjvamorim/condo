<template>
  <div>
    <v-app-bar dark text color="grey-lighten" dense>
      <v-toolbar dense>Roles</v-toolbar>
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
      <template #items="props">
        <td>{{ props.item.name }}</td>

        <td class="justify-center layout px-0">
          <v-icon small class="mr-2" @click="editItem(props.item)">edit</v-icon>
          <v-icon small @click="deleteItem(props.item)">delete</v-icon>
        </td>
      </template>
      <template #item.permissions="{ item }">
        <v-chip
          v-for="(permission, index) in item.permissions"
          :key="index"
          small
          color="primary"
          text-color="white"
          >{{ permission.name }}</v-chip
        >
      </template>
      <template #item.action="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">edit</v-icon>
        <v-icon small @click="deleteItem(item)">delete</v-icon>
      </template>
      <template #no-data>
        <v-btn color="primary" @click="initialize">Reset</v-btn>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    dialog: false,
    headers: [
      { text: "Name", value: "name" },
      { text: "Permissions", value: "permissions" },
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
      axios.get("/api/roles").then((response) => {
        this.tableData = response.data;
      });

      axios
        .get("/api/permissions")
        .then((response) => (this.allPermissions = response.data));
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
        .delete("/api/roles/" + item.id)
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
          .put("/api/roles/" + this.editedItem.id, this.editedItem)
          .then((response) => console.log(response.data));
      } else {
        this.tableData.push(this.editedItem);

        axios
          .post("/api/roles", this.editedItem)
          .then((response) => console.log(response.data));
      }
      this.close();
    },
  },
};
</script>
