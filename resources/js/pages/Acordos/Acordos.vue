<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title>
      Proprietários
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Buscar"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>
    <v-card-text>
      <a :href="'/admin/acordo_novo'">
        <v-icon color="primary">mdi-plus-circle-outline</v-icon>
      </a>

      <v-dialog v-model="dialog" max-width="1200px">
        <!--Formulario-->
        <AcordoDetalhes
          ref="AcordoDetalhes"
          :acordo="item"
          :all-unidades="allUnidades"
        ></AcordoDetalhes>
      </v-dialog>
      <v-data-table
        :headers="headers"
        :items="tableData"
        :search="search"
        :items-per-page="-1"
        dense
        fixed-header
        :must-sort="true"
        sort-by="id"
        class="elevation-1"
        sort-desc
        @click:row="show"
      >
        <template #item.unidade_id="{ item }">
          {{ unidadeDescricao(item.unidade_id) }}
        </template>
        <template #item.action="{ item }">
          <v-icon small @click="show(item)">pageview_outline</v-icon>
          <!-- <v-icon small @click="deleteItem(item)">delete</v-icon> -->
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script lang="js">
import axios from "axios";
import AcordoDetalhes from "./AcordoDetalhes";
export default {
  components: { AcordoDetalhes },
  data: () => ({
    search: "",
    item: "",
    dialog: false,
    headers: [
      { text: "Id", value: "id" },
      { text: "Unidade", value: "unidade_id" },
      { text: "data", value: "data" },
      { text: "Situação", value: "situacao" },
      { text: "Ações", value: "action", sortable: false },
    ],
    tableData: [],
    allUnidades: [{ id: "00", descricao: "Todos" }],
    filtroItem: {
      unidade_id: "",
    },
  }),

  computed: {
    formTitle() {
      return "Acordo: " + this.item.id;
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
    buscaAcordos() {
      this.tableData = [];
      axios
        .get("/api/acordos", { params: this.filtroItem })
        .then((response) => {
          this.tableData = response.data;
        })
        .catch((error) => console.log(error));
    },
    initialize() {
      axios
        .get("/api/unidades")
        .then((response) => {
          this.allUnidades = response.data;
          this.allUnidades.sort();
          this.allUnidades.unshift({ id: "00", descricao: "Todos" });
        })
        .catch((error) => console.log(error));
      this.buscaAcordos();
    },

    show(item) {
      this.item = item;

      this.dialog = true;
      //this.$refs.AcordoDetalhes.$mount;
      setTimeout(() => {
        this.$refs.AcordoDetalhes.buscaTermosAcordo(item.id);
        this.$refs.AcordoDetalhes.tab = 0;
      }, 100);

      //this.$refs.AcordoDetalhes.$forceUpdate();
    },

    close() {
      this.dialog = false;
    },

    unidadeDescricao(id) {
      return this.allUnidades.find((x) => x.id == id)
        ? this.allUnidades.find((x) => x.id == id).descricao
        : "";
    },
  },
};
</script>

<style scooped></style>
