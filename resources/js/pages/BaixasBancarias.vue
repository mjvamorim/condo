<template>
  <v-card>
    <v-card-title>
      <span class="headline">Baixas Bancárias API</span>
    </v-card-title>
    <v-card-text>
      <v-file-input
        v-model="files"
        small-chips
        multiple
        accept=".txt"
        label="Clique aqui e selecione o(s) arquivos de baixa"
      >
      </v-file-input>
      <v-textarea v-model="log" outlined label="Mensagem"> </v-textarea>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue " text to="/admin/">Voltar</v-btn>
      <v-btn color="blue darken-1" text @click="save">Salvar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    files: null,
    log: "",
  }),

  methods: {
    save() {
      let header = { headers: { "Content-Type": "multipart/form-data" } };
      if (this.files) {
        let formData = new FormData();
        this.files.forEach((file, i) => {
          formData.append("files[" + i + "]", file, file.name);
        });
        axios
          .post("/api/baixasBancaria", formData, header)
          .then((response) => {
            console.log(response.data);
            this.files = null;
            this.log = response.data;
            // self.$router.push('/admin');
            //alert('Log Salvo!')
          })
          .catch((error) => {
            alert(error.response.data.message);
          });
      } else {
        alert("Nenhum arquivo foi selecionado.");
      }
    },
  },
};
</script>
