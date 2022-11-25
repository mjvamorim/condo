<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title> Unidade: {{ unidade.descricao }}</v-card-title>
    <v-card-text> </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue darken-1" text to="/admin/">Voltar</v-btn>
      <!-- <v-btn color="primary" text @click="">Executar</v-btn> -->
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    unidade_id: 0,
    unidade: {},
  }),
  created() {
    this.unidade_id = this.$route.query.id;
    console.log(this.unidade_id);
    axios
      .get("/api/unidades/" + this.unidade_id)
      .then((response) => {
        this.unidade = response.data;
        console.log(response.data);
      })
      .catch((error) => console.log(error));
  },
  methods: {},
};
</script>
<style scooped></style>
