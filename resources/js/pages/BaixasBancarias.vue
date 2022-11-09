<template>   
  <v-card>
    <v-card-title>
      <span class="headline">Baixas Bancárias</span>
    </v-card-title>
    <v-card-text>
      <v-file-input v-model="files" small-chips  multiple
        accept=".txt"
        label="Clique aqui e selecione o(s) arquivos de baixa">
      </v-file-input>
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
   files: null,
  }),
  
  methods: {
    save() {
      if(this.files) {
        let formData = new FormData();
        for (let file of this.files) {
            formData.append("file", file, file.name);
        }
        axios
        .post("/financeiro/baixasBancaria", formData)
        .then((response) => {
            console.log(response);
            self.$router.push('/admin');
            //alert('Log Salvo!')
        })
        .catch((error) => {
          alert(error.response.data.message)
        });
      } else {
        alert("Nenhum arquivo foi selecionado.");
      }
    } 
  },
};
</script>
  