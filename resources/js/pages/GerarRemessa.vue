<template>
    <v-card elevation="2" outlined shaped>
      <v-card-title>
        Gerar Remessa 03
  
      </v-card-title>
      <v-card-text>
       


      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue " text to="/admin/">Voltar</v-btn>
        <v-btn color="primary" text @click="gerarRemessa">Executar</v-btn>
      </v-card-actions>
    </v-card>
  </template>
    
  <script>
  export default {
    data: () => ({

      
    }),
    created() {
      this.inicializa();
    },
    methods: {
      inicializa() {
      
      },
      gerarRemessa() {
        if(confirm("Confirma a geração das Remessa?")){
          axios
          .post("/financeiro/gerarRemessa")
          .then((response) => {
            alert('Boletos Gerados!')
            console.log(response);
            var fileName = xhr.getResponseHeader('content-disposition').split('filename=')[1].split(';')[0];
            console.log(fileName);
          })
          .catch((error) => {
            if (error.response) {
              // The request was made and the server responded with a status code
              // that falls out of the range of 2xx
              console.log(error.response);
              alert(error.response.data.errors[0]);
            } 
            
          });
        }
      }
    },
  };
  </script>
  <style scooped>
  .v-input {
    font-size: 18px;
  }
  </style>
    