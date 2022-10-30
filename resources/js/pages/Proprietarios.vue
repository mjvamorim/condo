<template>
  <div>
    <v-app-bar dark text color="grey-lighten" dense>
      <v-toolbar dense>Proprietarios</v-toolbar>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-dialog v-model="dialog" max-width="700px">
        <template v-slot:activator="form">
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-btn icon v-bind="attrs" v-on="on">
                <v-icon v-on="form.on">mdi-plus</v-icon>
              </v-btn>
            </template>
            <span>Cadastrar novo Item</span>
          </v-tooltip>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>

          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.nome"
                    outlined
                    label="Nome"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.email"
                    outlined
                    label="Email"
                    :rules="[rules.email]"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.celular"
                    outlined
                    label="Celular"
                    v-mask="[
                                            '(##)####-####',
                                            '(##)#####-####'
                                        ]"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.fixo"
                    outlined
                    label="Telefone Fixo"
                    v-mask="[
                                            '(##)####-####',
                                            '(##)#####-####'
                                        ]"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.cpf"
                    outlined
                    label="CPF/CNPJ"
                    :rules="[rules.required]"
                    v-mask="[
                                            '###.###.###-##',
                                            '##.###.###/####-##'
                                        ]"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.cep"
                    outlined
                    label="Cep"
                    :rules="[rules.required]"
                    v-mask="['#####-###']"
                    @blur="buscar_cep"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.rua"
                    outlined
                    label="Rua"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field v-model="editedItem.numero" outlined label="Número"></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field v-model="editedItem.complemento" outlined label="Complemento"></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.bairro"
                    outlined
                    label="Bairro"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-text-field
                    v-model="editedItem.cidade"
                    outlined
                    label="Cidade"
                    :rules="[rules.required]"
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-select
                    v-model="editedItem.uf"
                    :items="allEstados"
                    outlined
                    label="Estados"
                    item-text="uf"
                    return-values
                    :rules="[rules.required]"
                  ></v-select>
                </v-flex>

                <v-flex xs12>
                  <v-text-field v-model="editedItem.pais" outlined label="pais"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="save">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-app-bar>
    <v-data-table
      dense
      :headers="headers"
      :items="tableData"
      :items-per-page="15"
      :search="search"
      class="elevation-1"
      sort-by="nome"
    >
      <template v-slot:item.action="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{on, attrs }">
            <v-icon small class="mr-2" @click="editItem(item)" v-bind="attrs" v-on="on">edit</v-icon>
          </template>
          <span>Alterar</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{on, attrs }">
            <v-icon small @click="deleteItem(item)" v-bind="attrs" v-on="on">delete</v-icon>
          </template>
          <span>Apagar</span>
        </v-tooltip>
      </template>
    </v-data-table>
  </div>
</template>

<script>
export default {
  data: () => ({
    search: "",
    cep: "",
    endereco: {},
    naoLocalizado: false,
    dialog: false,
    headers: [
      { text: "Nome", value: "nome" },
      { text: "Email", value: "email" },
      { text: "Celular", value: "celular" },
      { text: "Cpf", value: "cpf" },
      { text: "Actions", value: "action", sortable: false },
    ],
    tableData: [],
    editedIndex: -1,
    allEstados: [],
    editedItem: {
      nome: "",
      email: "",
      celular: "",
      fixo: "",
      cpf: "",
      cep: "",
      rua: "",
      numero: "",
      complemento: "",
      bairro: " ",
      cidade: "",
      uf: "",
      pais: "",
      created_at: "",
    },
    defaultItem: {
      nome: "",
      email: "",
      celular: "",
      fixo: "",
      cpf: "",
      cep: "",
      rua: "",
      numero: "",
      complemento: "",
      bairro: " ",
      cidade: "",
      uf: "",
      pais: "Brasil",
      created_at: "",
    },
    rules: {
      required: (value) => !!value || "*Obrigatório",
      counter: (value) => value.length <= 20 || "Max 20 characters",
      email: (value) => {
        const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return pattern.test(value) || "Invalid e-mail.";
      },
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Item" : "Edit Item";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      axios
        .get("/api/proprietarios")
        .then((response) => {
          this.tableData = response.data;
        })
        .catch((error) => console.log(error));

      axios
        .get("/api/estados")
        .then((response) => {
          this.allEstados = response.data;
        })
        .catch((error) => console.log(error));
    },

    editItem(item) {
      this.editedIndex = this.tableData.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.tableData.indexOf(item);
      confirm("Você deseja apagar este item?") &&
        axios
          .delete("/api/proprietarios/" + item.id)
          .then((response) => {
            console.log(response.data);
            this.tableData.splice(index, 1);
          })
          .catch((error) => console.log(error));
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        axios
          .put("/api/proprietarios/" + this.editedItem.id, this.editedItem)
          .then((response) => {
            console.log(response.data);
            Object.assign(this.tableData[this.editedIndex], this.editedItem);
            this.close();
          })
          .catch((error) => console.log(error));
      } else {
        axios
          .post("/api/proprietarios/", this.editedItem)
          .then((response) => {
            console.log(response.data);
            this.tableData.push(this.editedItem);
            this.close();
          })
          .catch((error) => console.log(error));
      }
    },
    buscar_cep() {
      console.log("Buscar cep2");
      var url = "https://viacep.com.br/ws/" + this.editedItem.cep + "/json/";
      if (/^[0-9]{5}-[0-9]{3}$/.test(this.editedItem.cep)) {
        let axios_instance = axios.create();
        delete axios_instance.defaults.headers.common["X-CSRF-TOKEN"];
        axios_instance.get(url).then((response) => {
          let endereco = response.data;
          if (!this.editedItem.rua) {
            this.editedItem.rua = endereco.logradouro;
            this.editedItem.bairro = endereco.bairro;
            this.editedItem.cidade = endereco.localidade;
            this.editedItem.uf = endereco.uf;
          }
        });
      }
    },
  },
};

// $.getJSON(
//     ,
//     function(endereco) {
//         if (endereco.erro) {
//             this.endereco = {};
//             return;
//         }
// this.editedItem.rua = endereco.logradouro;
// this.editedItem.bairro = endereco.bairro;
// this.editedItem.cidade = endereco.localidade;
// this.editedItem.uf = endereco.uf;
// console.log(endereco);
//     }
// );
</script>
