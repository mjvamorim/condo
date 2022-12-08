<template>
  <v-card flat>
    <v-card-title>
      <span class="headline">Unidade</span>
    </v-card-title>
    <v-card-text>
      <v-container grid-list-md>
        <v-layout wrap>
          <v-flex xs12>
            <v-text-field
              v-model="unidade.descricao"
              label="Descrição"
              outlined
              :rules="[rules.required]"
            ></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-text-field
              v-model="unidade.adicional"
              v-mask="['####.###']"
              label="Adicional"
              outlined
            ></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-radio-group
              v-model="unidade.tipo_adicional"
              label="Tipo Adicional"
              col
              dense
              :mandatory="true"
            >
              <v-radio label="Valor Fixo" value="Valor Fixo"></v-radio>
              <v-radio label="Percentual" value="Percentual"></v-radio>
            </v-radio-group>
          </v-flex>
          <v-flex xs12>
            <v-select
              v-model="unidade.proprietario_id"
              :items="allProprietarios"
              label="Proprietários"
              item-text="nome"
              item-value="id"
              outlined
              return-value
              :rules="[rules.required]"
            ></v-select>
          </v-flex>
          <v-flex xs12>
            <v-textarea
              v-model="unidade.moradores"
              label="Moradores"
              outlined
            ></v-textarea>
          </v-flex>
          <v-flex xs12>
            <v-textarea
              v-model="unidade.veiculos"
              label="Veículos"
              outlined
            ></v-textarea>
          </v-flex>
          <v-flex xs12>
            <v-text-field
              v-model="unidade.ramal"
              label="Ramal"
              outlined
            ></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-textarea v-model="unidade.obs" label="Obs" outlined></v-textarea>
          </v-flex>

          <v-flex xs12>
            <v-radio-group
              v-model="unidade.envio_boleto"
              label="Envio Boleto"
              col
              dense
              :mandatory="true"
            >
              <v-radio label="Impresso" value="Impresso"></v-radio>
              <v-radio label="Ambos" value="Ambos"></v-radio>
              <v-radio label="Email" value="Email"></v-radio>
            </v-radio-group>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="danger" text @click="close">Retornar</v-btn>
      <v-btn color="primary" text @click="save">Salvar</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  props: {
    // eslint-disable-next-line vue/require-default-prop
    unidade: {
      descricao: "",
      adicional: "",
      tipo_adicional: "",
      proprietario_id: "",
      obs: "",
      envio_boleto: "",
      created_at: "",
    },
  },
  emits: ["on-close", "on-save"],
  data: () => ({
    //Variavel menu controla a exibição da data no Datapicker
    allProprietarios: [{ id: "", nome: "" }],
    rules: {
      required: (value) => !!value || "*Obrigatório",
    },
  }),

  created() {
    // this.unidade = Object.assign({}, this.unidade);
    axios
      .get("/api/proprietarios")
      .then((response) => {
        this.allProprietarios = response.data;
        this.allProprietarios.sort();
      })
      .catch((error) => console.log(error));
  },

  methods: {
    close() {
      this.$emit("on-close");
    },

    save() {
      if (this.unidade.id > 0) {
        axios
          .put("/api/unidades/" + this.unidade.id, this.unidade)
          .then((response) => {
            console.log(response.data);
            this.$emit("on-save", this.unidade);
          })
          .catch((error) => console.log(error));
      } else {
        //console.log(this.unidade);
        axios
          .post("/api/unidades/", this.unidade)
          .then((response) => {
            console.log(response.data);
            console.log(this.unidade);
            this.$emit("on-save", this.unidade);
          })
          .catch((error) => console.log(error));
      }
    },
  },
};
</script>

<style scooped></style>
