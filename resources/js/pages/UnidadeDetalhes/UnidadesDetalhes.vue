<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title>
      Unidade: {{ unidade.descricao }} <br /><br />
      Proprietario: {{ nomeProprietario }}<br /><br />
      <v-flex xs12>
        <v-textarea
          v-model="unidade.obs"
          readonly
          label="Obs"
          outlined
        ></v-textarea>
      </v-flex>
    </v-card-title>

    <v-card-text>
      <v-tabs v-model="tab" align-with-title>
        <v-tabs-slider></v-tabs-slider>

        <v-tab> Débitos </v-tab>
        <v-tab> Alterar Dados </v-tab>

        <v-tab> Documentos </v-tab>
      </v-tabs>
      <v-tabs-items
        v-model="tab"
        style="border: 1px solid gray; border-radius: 5px"
      >
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
          <DocumentosTable :unidade_id="unidade_id" />
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
import DocumentosTable from "./DocumentosTable.vue";
import UnidadeForm from "./UnidadeForm.vue";
export default {
  components: { DebitosTable, UnidadeForm, DocumentosTable },
  data: () => ({
    tab: null,
    unidade_id: 0,
    unidade: {
      descricao: "",
      adicional: "",
      tipo_adicional: "",
      proprietario_id: "",
      obs: "",
      envio_boleto: "",
      created_at: ""
    },
    nomeProprietario: "*** proprietario inválido ***"
  }),
  created() {
    this.unidade_id = this.$route.query.id;
    // console.log(this.unidade_id);
    axios
      .get("/api/unidades/" + this.unidade_id)
      .then(response => {
        this.unidade = response.data;
        axios
          .get("/api/proprietarios/" + this.unidade.proprietario_id)
          .then(response => {
            this.nomeProprietario = response.data.nome;
            console.log(response.data);
          });
      })
      .catch(error => console.log(error));
  },
  methods: {
    closeForm() {
      this.tab = 0;
      console.log("Close Form");
    },
    saveForm() {
      this.tab = 0;
      console.log("Save Form");
    }
  }
};
</script>
<style scooped></style>
