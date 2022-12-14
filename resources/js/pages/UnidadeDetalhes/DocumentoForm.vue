<template>
  <v-card>
    <v-card-title>
      <span class="headline">Documento</span>
    </v-card-title>
    <v-card-text>
      <v-container grid-list-md>
        <v-layout wrap>
          <v-flex xs12>
            <v-select
              v-model="documento.unidade_id"
              :items="allUnidades"
              label="Unidade"
              item-text="descricao"
              item-value="id"
              outlined
              return-value
              :rules="[rules.required]"
            ></v-select>
          </v-flex>

          <v-flex xs12>
            <v-text-field
              v-model="documento.descricao"
              outlined
              label="Descrição"
              :rules="[rules.required]"
            ></v-text-field>
          </v-flex>
          <v-flex xs12>
            <v-file-input
              v-model="documento.arquivo"
              small-chips
              accept="*.pdf"
              label="Arquivo"
            >
            </v-file-input>
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
    documento: {
      id: 0,
      unidade_id: "",
      descricao: "",
      arquivo: []
    }
  },
  emits: ["on-close", "on-save"],
  data: () => ({
    allUnidades: [],
    rules: {
      required: value => !!value || "*Obrigatório"
    }
  }),

  created() {
    axios
      .get("/api/unidades")
      .then(response => {
        this.allUnidades = response.data;
        this.allUnidades.sort();
      })
      .catch(error => console.log(error));
  },

  methods: {
    close() {
      this.$emit("on-close");
    },

    save() {
      let formData = new FormData();
      formData.append("id", this.documento.id);
      formData.append("unidade_id", this.documento.unidade_id);
      formData.append("descricao", this.documento.descricao);
      formData.append(
        "arquivo",
        this.documento.arquivo,
        this.documento.arquivo.name
      );
      if (this.documento.id > 0) {
        axios
          .put("/api/documentos/" + this.documento.id, formData)
          .then(response => {
            console.log(response.data);
            this.$emit("on-save", this.documento);
          })
          .catch(error => console.log(error));
      } else {
        //console.log(this.documento);
        axios
          .post("/api/documentos/", formData)
          .then(response => {
            console.log(response.data);
            console.log(this.documento);
            Object.assign(this.documento, response.data);
            console.log(this.documento);
            this.documento.arquivo = [];
            this.$emit("on-save", this.documento);
          })
          .catch(error => console.log(error));
      }
    }
  }
};
</script>

<style scooped></style>
