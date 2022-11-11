<template>
  <v-card>
    <v-card-title>
      <span class="headline">Log Baixas</span>
    </v-card-title>
    <v-card-text>
      <v-textarea v-model="log.log" outlined label="Mensagem"> </v-textarea>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue " text to="/admin/">Voltar</v-btn>
      <v-btn color="blue darken-1" text @click="save">Salvar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
export default {
  data: () => ({
    log: {
      log: "",
    },
  }),
  created() {
    axios
      .get("/log/file")
      .then((response) => {
        this.log.log = response.data;
      })
      .catch((error) => console.log(error));
  },
  methods: {
    save() {
      axios
        .post("/log/save/", this.log)
        .then((response) => {
          console.log(response.data);
          alert("Log Salvo!");
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
