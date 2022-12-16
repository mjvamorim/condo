<template>
  <v-card min-height="600px" style="padding: 10px">
    <h3>Acordo</h3>
    <v-tabs v-model="tab" dense dark>
      <v-tabs-slider></v-tabs-slider>
      <v-tab>Identificação</v-tab>
      <v-tab>Composição</v-tab>
      <v-tab>Prestações</v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item>
        <v-card flat>
          <v-card-title>
            <span class="headline"></span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12>
                  <v-text-field
                    v-model="acordo.id"
                    label="Acordo"
                    outlined
                    disabled
                  ></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field
                    v-model="acordo.data"
                    label="Data "
                    outlined
                    disabled
                  ></v-text-field>
                </v-flex>

                <v-flex xs12>
                  <v-textarea
                    v-model="acordo.termos"
                    disabled
                    label="Termos"
                    outlined
                  ></v-textarea>
                </v-flex>
                <v-flex xs12>
                  <v-text-field
                    v-model="acordo.situacao"
                    disabled
                    label="Situacao"
                    outlined
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <h4>Composição</h4>
          <v-data-table
            :headers="headers"
            :items="tableDataComposicao"
            fixed-header
            dense
            disable-pagination
            :items-per-page="15"
            :must-sort="true"
            sort-by="dtvencto"
            hide-default-footer
            class="elevation-1"
          >
            <template #item.unidade_id="{ item }">
              {{ unidadeDescricao(item.unidade_id) }}
            </template>

            <template #item.valor="{ item }">
              <div class="text-right">
                R$ {{ item.valor ? item.valor.toFixed(2) : "0,00" }}
              </div>
            </template>
            <template #item.valorpago="{ item }">
              <div class="text-right">
                R$ {{ item.valorpago ? item.valorpago.toFixed(2) : "0.00" }}
              </div>
            </template>
            <template #item.valoratual="{ item }">
              <div class="text-right">R$ {{ item.valoratual.toFixed(2) }}</div>
            </template>
          </v-data-table>
        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card flat>
          <h4>Prestações</h4>
          <v-data-table
            :headers="headers"
            :items="tableDataPrestacoes"
            fixed-header
            dense
            disable-pagination
            :items-per-page="100"
            :must-sort="true"
            sort-by="dtvencto"
            hide-default-footer
            class="elevation-1"
          >
            <template #item.unidade_id="{ item }">
              {{ unidadeDescricao(item.unidade_id) }}
            </template>

            <template #item.valor="{ item }">
              <div class="text-right">
                R$ {{ item.valor ? item.valor.toFixed(2) : "0,00" }}
              </div>
            </template>
            <template #item.valorpago="{ item }">
              <div class="text-right">
                R$ {{ item.valorpago ? item.valorpago.toFixed(2) : "0.00" }}
              </div>
            </template>
            <template #item.valoratual="{ item }">
              <div class="text-right">R$ {{ item.valoratual.toFixed(2) }}</div>
            </template>
          </v-data-table>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  name: "AcordoDetalhes",
  props: ["acordo", "allUnidades"],
  data: () => ({
    tab: null,
    headers: [
      { text: "Unidade", value: "unidade_id" },
      { text: "Tipo", value: "tipo" },
      { text: "Dt.Vencto", value: "dtvencto" },
      { text: "Valor", value: "valor" },
      { text: "Dt.Pagto", value: "dtpagto" },
      { text: "Vl.Pago", value: "valorpago" },
      { text: "Boleto", value: "boleto" },
      { text: "Vl.Devido", value: "valoratual" },
      { text: "Acordo", value: "acordo_quitacao_id" }, //confirmar se é esse valor msm
      { text: "", value: "action", sortable: false },
    ],
    tableDataComposicao: [],
    tableDataPrestacoes: [],
    filtroComposicao: {
      acordo_quitacao_id: 0,
    },
    filtroPrestacoes: {
      acordo_id: 0,
    },
    editedItem: {
      id: 0,
      unidade_id: "",
      data: "",
      termos: "",
      situacao: "",
      created_at: "",
    },
  }),
  created() {
    // this.buscaTermosAcordo();
    console.log("Created ");
  },

  methods: {
    unidadeDescricao(id) {
      return this.allUnidades.find((x) => x.id == id)
        ? this.allUnidades.find((x) => x.id == id).descricao
        : "";
    },
    buscaTermosAcordo(id) {
      this.filtroComposicao.acordo_quitacao_id = id ? id : 1;
      this.filtroPrestacoes.acordo_id = id ? id : 1;

      this.tableDataComposicao = [];
      axios
        .get("/api/debitos", { params: this.filtroComposicao })
        .then((response) => {
          this.tableDataComposicao = response.data;
        })
        .catch((error) => console.log(error));

      this.tableDataPrestacoes = [];
      axios
        .get("/api/debitos", { params: this.filtroPrestacoes })
        .then((response) => {
          this.tableDataPrestacoes = response.data;
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>

<style scooped>
.acordos-table table th {
  background-color: gray !important;
  font-size: 13px !important;
}
.col {
  padding: 2px;
}
.v-btn {
  text-transform: none;
  margin-left: 10px;
}
.v-card {
  padding: 20px;
}
</style>
