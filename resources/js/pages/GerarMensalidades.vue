<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title> Gerar Mensalidades </v-card-title>
    <v-card-text>
      <v-select
        v-model="taxa_id"
        :items="allTaxas"
        label="Taxa"
        item-text="anomes"
        item-value="id"
        outlined
        return-value
        :rules="[rules.required]"
      ></v-select>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue darken-1" text to="/admin/">Voltar</v-btn>
      <v-btn color="primary" text @click="gerarMensalidades">Executar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    allTaxas: [],
    taxa_id: 0,
    rules: {
      required: (value) => !!value || "*Obrigatório",
    },
  }),
  created() {
    this.initialize();
  },
  methods: {
    initialize() {
      axios
        .get("/api/taxas")
        .then((response) => {
          this.allTaxas = response.data;
        })
        .catch((error) => console.log(error));
    },
    gerarMensalidades() {
      console.log(this.taxa_id);
      if (
        this.taxa_id &&
        confirm(
          "Confirma a geração das mensalidades para " + this.taxa_id + "?"
        )
      ) {
        axios
          .post("/financeiro/gerarMensalidades", this.taxa_id)
          .then((response) => {
            alert("Boletos Gerados!");
            console.log(response);
          })
          .catch((error) => console.log(error));
      }
    },
  },
};
</script>
<style scooped>
.v-input {
  font-size: 18px;
}
</style>
