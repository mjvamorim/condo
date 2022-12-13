<template>
  <v-card flat>
    <v-card-title>
      <v-tooltip bottom>
        <template #activator="{ on, attrs }">
          <v-fab-transition>
            <v-btn
              fab
              top
              right
              outlined
              small
              color="primary"
              v-bind="attrs"
              v-on="on"
              @click="newItem(documento)"
            >
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </v-fab-transition>
        </template>
        <span>Cadastrar novo Documento</span>
      </v-tooltip>
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
      <v-dialog v-model="showForm" max-width="600">
        <DocumentosForm
          :documento="documento"
          @on-close="closeForm"
          @on-save="saveForm"
        />
      </v-dialog>

      <v-data-table
        :headers="headers"
        :items="documentos"
        :search="search"
        fixed-header
        dense
        :must-sort="true"
        sort-by="id"
        class="elevation-1"
        :items-per-page="20"
        :footer-props="{ 'items-per-page-options': [10, 20, 30, 40, -1] }"
      >
        <template #item.unidade_id="{ item }">
          {{ unidadeDescricao(item.unidade_id) }}
        </template>
        <template #item.action="{ item }">
          <v-tooltip bottom>
            <template #activator="{ on, attrs }">
              <v-icon
                small
                class="mr-2"
                v-bind="attrs"
                @click="download(item)"
                v-on="on"
                >download</v-icon
              >
            </template>
            <span>Download</span>
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
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from "axios";
import { mdiBarcode } from "@mdi/js";
import DocumentosForm from "./DocumentoForm.vue";
export default {
  components: { DocumentosForm },
  // eslint-disable-next-line vue/prop-name-casing
  props: ["unidade_id"],
  data: () => ({
    //Documentos
    mdiBarcode,
    documentos: [],
    headers: [
      { text: "Id", value: "id" },
      { text: "Unidade", value: "unidade_id" },
      { text: "Descricao", value: "descricao" },
      { text: "Arquivo", value: "arquivo" },
      { text: "", value: "action", sortable: false },
    ],
    search: "",
    filtroItem: {
      unidade_id: "",
    },
    allUnidades: [],
    showForm: false,
    documento: {
      id: 0,
      unidade_id: "",
      descricao: "",
      arquivo: [],
    },
    index: 0,
  }),
  created() {
    axios
      .get("/api/unidades")
      .then((response) => {
        this.allUnidades = response.data;
        this.allUnidades.sort();
      })
      .catch((error) => console.log(error));
    this.buscaDocumentos();
  },
  methods: {
    buscaDocumentos() {
      this.filtroItem.unidade_id = this.unidade_id;
      axios
        .get("/api/documentos", { params: this.filtroItem })
        .then((response) => {
          this.documentos = response.data;
        })
        .catch((error) => console.log(error));
    },
    unidadeDescricao(id) {
      return this.allUnidades.find((x) => x.id == id)
        ? this.allUnidades.find((x) => x.id == id).descricao
        : "";
    },
    closeForm() {
      this.showForm = false;
    },
    saveForm(documento) {
      this.documentos.push(documento);
      this.showForm = false;
    },
    newItem() {
      this.documento.id = 0;
      this.documento.unidade_id = +this.unidade_id;
      this.documento.descricao = "";
      this.documento.arquivo = [];
      this.showForm = true;
    },
    download(item) {
      let url = "/api/documentoDownload/" + item.id;
      window.open(url, "_blank");
    },
    deleteItem(item) {
      const index = this.documentos.indexOf(item);
      confirm("Você deseja apagar este item?") &&
        axios
          .delete("/api/documentos/" + item.id)
          .then((response) => {
            console.log(response.data);
            this.documentos.splice(index, 1);
          })
          .catch((error) => console.log(error));
    },
  },
};
</script>
<style scooped></style>
