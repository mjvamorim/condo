<template>
  <div>
    <v-app-bar dark text color="grey-lighten" dense>
      <v-toolbar dense>Unidades</v-toolbar>
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
                    v-model="editedItem.descricao"
                    label="Descrição"
                    outlined
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.adicional"
                    v-mask="['####.###']"
                    label="Adicional"
                    outlined
                  ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-radio-group
                    v-model="editedItem.tipo_adicional"
                    label="Tipo Adicional"
                    col
                    dense
                    :mandatory="true"
                  >
                    <v-radio label="Valor Fixo" value="Valor Fixo"></v-radio>
                    <v-radio label="Percentual" value="Percentual"></v-radio>
                  </v-radio-group>
                </v-flex>
                <v-flex xs12>
                  <v-select
                    v-model="editedItem.proprietario_id"
                    :items="allProprietarios"
                    label="Proprietários"
                    item-text="nome"
                    item-value="id"
                    outlined
                    return-value
                    :rules="[rules.required]"
                  ></v-select>
                </v-flex>
                <v-flex xs12>
                  <v-textarea
                    v-model="editedItem.moradores"
                    label="Moradores"
                    outlined
                  ></v-textarea>
                </v-flex>
                <v-flex xs12>
                  <v-textarea
                    v-model="editedItem.veiculos"
                    label="Veículos"
                    outlined
                  ></v-textarea>
                </v-flex>
                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.ramal"
                    label="Ramal"
                    outlined
                  ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-textarea
                    v-model="editedItem.obs"
                    label="Obs"
                    outlined
                  ></v-textarea>
                </v-flex>

                <v-flex xs12>
                  <v-radio-group
                    v-model="editedItem.envio_boleto"
                    label="Envio Boleto"
                    col
                    dense
                    :mandatory="true"
                  >
                    <v-radio label="Impresso" value="Impresso"></v-radio>
                    <v-radio label="Ambos" value="Ambos"></v-radio>
                    <v-radio label="Email" value="Email"></v-radio>
                  </v-radio-group>
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
      :items-per-page="15"
      dense
      class="elevation-1"
      sort-by="descricao"
    >
      <template #item.proprietario_id="{ item }">
        {{ proprietarioNome(item.proprietario_id) }}
      </template>
      <template #item.adicional="{ item }">
        <div v-if="item.tipo_adicional == 'Valor Fixo'" class="text-left">
          R$ {{ item.adicional ? item.adicional.toFixed(2) : "0,00" }}
        </div>
        <div v-else class="text-right">{{ item.adicional }}%</div>
      </template>

      <template #item.action="{ item }">
        <v-icon small class="mr-2" @click="editItem(item)">edit</v-icon>
        <v-icon small class="mr-2" @click="deleteItem(item)">delete</v-icon>
        <v-icon small class="mr-2" @click="details(item)">apps</v-icon>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    search: "",
    naoLocalizado: false,
    dialog: false,
    headers: [
      { text: "Descrição", value: "descricao" },
      // { text: "Adicional", value: "adicional" },
      { text: "Proprietários", value: "proprietario_id" },
      { text: "Moradores", value: "moradores" },
      { text: "Veículos", value: "veiculos" },
      { text: "Ramal", value: "ramal" },
      { text: "Actions", value: "action", sortable: false },
    ],
    tableData: [],
    editedIndex: -1,
    allProprietarios: [{ id: "", nome: "" }],
    editedItem: {
      descricao: "",
      adicional: "",
      tipo_adicional: "",
      proprietario_id: "",
      obs: "",
      envio_boleto: "",
      created_at: "",
    },
    defaultItem: {
      descricao: "",
      adicional: "0",
      tipo_adicional: "Valor Fixo",
      proprietario_id: "",
      obs: "",
      envio_boleto: "Impresso",
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
    initialize() {
      axios
        .get("/api/unidades")
        .then((response) => {
          this.tableData = response.data;
        })
        .catch((error) => console.log(error));

      axios
        .get("/api/proprietarios")
        .then((response) => {
          this.allProprietarios = response.data;
        })
        .catch((error) => console.log(error));
    },

    editItem(item) {
      this.editedIndex = this.tableData.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    details(item) {
      this.$router.push({
        path: "/admin/unidades_detalhes/",
        query: { id: item.id },
      });
    },

    deleteItem(item) {
      const index = this.tableData.indexOf(item);
      confirm("Você deseja apagar este item?") &&
        axios
          .delete("/api/unidades/" + item.id)
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
          .put("/api/unidades/" + this.editedItem.id, this.editedItem)
          .then((response) => {
            console.log(response.data);
            Object.assign(this.tableData[this.editedIndex], this.editedItem);
            this.close();
          })
          .catch((error) => console.log(error));
      } else {
        axios
          .post("/api/unidades/", this.editedItem)
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
    },
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
