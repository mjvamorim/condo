<template>
  <div>
    <v-app-bar dark text color="grey-lighten" dense>
      <v-toolbar dense>Taxa</v-toolbar>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="700px">
        <template #activator="form">
          <v-tooltip bottom>
            <template #activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon v-on="form.on">mdi-plus</v-icon>
              </v-btn>
            </template>
            <span>Cadastrar novo Item</span>
          </v-tooltip>
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
                    v-model="editedItem.anomes"
                    v-mask="['####-##']"
                    label="Ano/Mês"
                    outlined
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-menu
                    v-model="menu"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                    min-width="290px"
                  >
                    <template #activator="{ on, attrs }">
                      <v-text-field
                        v-model="editedItem.dtvencto"
                        label="Vencimento"
                        outlined
                        v-bind="attrs"
                        :rules="[rules.required]"
                        v-on="on"
                      ></v-text-field>
                    </template>
                    <v-date-picker
                      v-model="editedItem.dtvencto"
                      no-title
                      @input="menu = false"
                    ></v-date-picker>
                  </v-menu>
                </v-flex>
                <v-flex xs12>
                  <v-currency-field
                    v-model="editedItem.valor"
                    label="Valor"
                    outlined
                    :rules="[rules.required]"
                  />
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn color="primary" text @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-app-bar>
    <v-data-table
      :headers="headers"
      :items="tableData"
      :search="search"
      sort-by="anomes"
      sort-desc
      class="elevation-1"
      items-per-page="15"
    >
      <template #item.action="{ item }">
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-icon
              small
              class="mr-2"
              v-bind="attrs"
              @click="editItem(item)"
              v-on="on"
              >edit</v-icon
            >
          </template>
          <span>Alterar</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template #activator="{ on, attrs }">
            <v-icon small v-bind="attrs" @click="deleteItem(item)" v-on="on"
              >delete</v-icon
            >
          </template>
          <span>Apagar</span>
        </v-tooltip>
      </template>
      <template #item.valor="{ item }">
        <div class="text-right">R$ {{ item.valor.toFixed(2) }}</div>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    menu: "",
    search: "",
    naoLocalizado: false,
    dialog: false,
    headers: [
      { text: "Ano/Mês", value: "anomes" },
      { text: "Vencimento", value: "dtvencto" },
      { text: "Valor", value: "valor" },
      { text: "", value: "action", sortable: false },
    ],
    tableData: [],
    editedIndex: -1,
    editedItem: {
      anomes: "",
      dtvencto: "",
      valor: "",
      created_at: "",
    },
    defaultItem: {
      anomes: "",
      dtvencto: "",
      valor: "",
      created_at: "",
    },
    rules: {
      required: (value) => !!value || "*Obrigatório",
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
    cleanData() {
      this.editedItem.dtvencto = "";
    },
    initialize() {
      axios
        .get("/api/taxas")
        .then((response) => {
          this.tableData = response.data;
        })
        .catch((error) => console.log(error));
    },

    editItem(item) {
      this.editedIndex = this.tableData.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.tableData.indexOf(item);
      confirm("Você deseja apagar este item?") &&
        axios
          .delete("/api/taxas/" + item.id)
          .then((response) => {
            console.log(response.data);
            this.tableData.splice(index, 1);
          })
          .catch((error) => console.log(error));
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
        axios
          .put("/api/taxas/" + this.editedItem.id, this.editedItem)
          .then((response) => {
            console.log(response.data);
            Object.assign(this.tableData[this.editedIndex], this.editedItem);
            this.close();
          })
          .catch((error) => console.log(error));
      } else {
        console.log(this.editedItem);
        axios
          .post("/api/taxas/", this.editedItem)
          .then((response) => {
            console.log(response.data);
            this.tableData.push(this.editedItem);
            this.close();
          })
          .catch((error) => console.log(error));
      }
    },
    proprietarioNome(id) {
      return this.allProprietarios.find((x) => x.id == id)
        ? this.allProprietarios.find((x) => x.id == id).nome
        : "";
    }, //Preciso desse campo aqui???
  },
};
</script>

<style>
legend {
  margin-top: -20px;
  padding: 2px;

  background: white;
  width: fit-content;
  font-size: small;
}
.v-input {
  font-size: 13px;
}
.v-label {
  font-size: 13px;
}
.v-input--radio-group__input {
  border: solid 1px gray;
  display: flex;
  width: 100%;
  border-radius: 3px;
  margin-top: -25px;
  padding: 10px;
  margin-bottom: 5px;
}
.v-input--radio-group--row legend {
  align-self: inherit;
}

.v-input--radio-group--column .v-radio:not(:last-child):not(:only-child) {
  margin-bottom: 0;
}
</style>
