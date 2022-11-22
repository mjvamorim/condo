<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title> Gerar Remessa </v-card-title>
    <v-card-text> </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue " text to="/admin/">Voltar</v-btn>
      <v-btn color="primary" text @click="gerarRemessa">Executar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({}),
  created() {
    this.inicializa();
  },
  methods: {
    inicializa() {},
    gerarRemessa() {
      const FileDownload = require("js-file-download");
      if (confirm("Confirma a geração das Remessa?")) {
        axios({
          url: "/financeiro/gerarRemessa",
          method: "POST",
          // responseType: 'blob', // important
        })
          .then((response) => {
            console.log(response);
            let fileName =
              response.headers["content-disposition"].split("filename=")[1];
            console.log(fileName);
            FileDownload(response.data, fileName);
          })
          .catch((error) => alert(error.response.data.error));
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
