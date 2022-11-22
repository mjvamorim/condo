<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title> Unidade: {{ unidade_id }} </v-card-title>
    <v-card-text> </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue darken-1" text to="/admin/">Voltar</v-btn>
      <v-btn color="primary" text @click="">Executar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    unidade_id: 0
  }),
  created() {
    this.unidade_id = this.$router.query.id;
    console.log(this.unidade_id);
  },
  methods: {}
};
</script>
<style scooped></style>
