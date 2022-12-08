<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title> Unidade: {{ unidade.descricao }}</v-card-title>
    <v-card-text>
      <v-tabs v-model="tab" align-with-title>
        <v-tabs-slider></v-tabs-slider>

        <v-tab> Débitos </v-tab>
        <v-tab> Dados </v-tab>

        <v-tab> Documentos </v-tab>
        <v-tab> Acordos </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <DebitosTable :unidade_id="unidade_id" />
        </v-tab-item>
        <v-tab-item>
          <UnidadeForm
            :unidade="unidade"
            @on-close="closeForm"
            @on-save="saveForm"
          />
        </v-tab-item>

        <v-tab-item>
          <v-card flat>
            <v-card-text>Documentos</v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>Acordos</v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <!-- <v-btn color="blue darken-1" text @click="$router.go(-1)">Voltar</v-btn> -->
      <!-- <v-btn color="primary" text @click="">Executar</v-btn> -->
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from "axios";
import DebitosTable from "./DebitosTable.vue";
import UnidadeForm from "./UnidadeForm.vue";
export default {
  components: { DebitosTable, UnidadeForm },
  data: () => ({
    unidade_id: 0,
    tab: null,
    unidade: {
      descricao: "",
      adicional: "",
      tipo_adicional: "",
      proprietario_id: "",
      obs: "",
      envio_boleto: "",
      created_at: "",
    },
  }),
  created() {
    this.unidade_id = this.$route.query.id;
    // console.log(this.unidade_id);
    axios
      .get("/api/unidades/" + this.unidade_id)
      .then((response) => {
        this.unidade = response.data;
        // console.log(response.data);
      })
      .catch((error) => console.log(error));
    this.buscaDebitos();
    axios
      .get("/api/proprietarios")
      .then((response) => {
        this.allProprietarios = response.data;
      })
      .catch((error) => console.log(error));
  },
  methods: {
    buscaDebitos() {
      this.debitos = [];
      axios
        .get("/api/debitos", { params: this.filtroItem })
        .then((response) => {
          this.tableData = response.data;
        })
        .catch((error) => console.log(error));
    },
    closeForm() {
      this.tab = 0;
      console.log("Close Form");
    },
    saveForm() {
      this.tab = 0;
      console.log("Save Form");
    },
  },
};
</script>
<style scooped></style>
