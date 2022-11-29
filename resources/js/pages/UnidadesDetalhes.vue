<template>
  <v-card elevation="2" outlined shaped>
    <v-card-title> Unidade: {{ unidade.descricao }}</v-card-title>
    <v-card-text>
      <v-tabs v-model="tab" align-with-title>
        <v-tabs-slider></v-tabs-slider>

        <v-tab> Débitos </v-tab>
        <v-tab> Dados </v-tab>

        <v-tab> Documentos </v-tab>
        <v-tab> Acordos </v-tab>
      </v-tabs>
      <v-tabs-items v-model="tab">
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <v-data-table
                :headers="headers"
                :items="debitos"
                :search="search"
                fixed-header
                dense
                :items-per-page="20"
                :must-sort="true"
                sort-by="unidade_id"
                class="elevation-1"
              >
                <template #item.unidade_id="{ item }">
                  {{ unidadeDescricao(item.unidade_id) }}
                </template>
                <template #item.action="{ item }">
                  <v-tooltip bottom>
                    <template #activator="{ on, attrs }">
                      <v-icon
                        small
                        class="mr-2"
                        v-bind="attrs"
                        @click="editItem(item)"
                        v-on="on"
                        >edit</v-icon
                      >
                    </template>
                    <span>Alterar</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template #activator="{ on, attrs }">
                      <v-icon
                        small
                        v-bind="attrs"
                        @click="deleteItem(item)"
                        v-on="on"
                        >delete</v-icon
                      >
                    </template>
                    <span>Apagar</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template #activator="{ on, attrs }">
                      <v-icon
                        small
                        v-bind="attrs"
                        @click="boletosImpressoUnico(item)"
                        v-on="on"
                        >{{ mdiBarcode }}
                      </v-icon>
                    </template>
                    <span>Boleto</span>
                  </v-tooltip>
                  <v-tooltip bottom>
                    <template #activator="{ on, attrs }">
                      <v-icon
                        small
                        v-bind="attrs"
                        @click="boletosEmailUnico(item)"
                        v-on="on"
                        >email</v-icon
                      >
                    </template>
                    <span>Boleto por Email</span>
                  </v-tooltip>
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
                  <div class="text-right">
                    R$ {{ item.valoratual.toFixed(2) }}
                  </div>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
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
                    <v-textarea
                      v-model="unidade.obs"
                      label="Obs"
                      outlined
                    ></v-textarea>
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
          </v-card>
        </v-tab-item>

        <v-tab-item>
          <v-card flat>
            <v-card-text>Documentos</v-card-text>
          </v-card>
        </v-tab-item>
        <v-tab-item>
          <v-card flat>
            <v-card-text>Acordos</v-card-text>
          </v-card>
        </v-tab-item>
      </v-tabs-items>
    </v-card-text>
    <v-card-actions>
      <v-spacer></v-spacer>
      <v-btn color="blue darken-1" text to="/admin/">Voltar</v-btn>
      <!-- <v-btn color="primary" text @click="">Executar</v-btn> -->
    </v-card-actions>
  </v-card>
</template>

<script>
import axios from "axios";
export default {
  data: () => ({
    unidade_id: 0,
    tab: null,
    unidade: {
      descricao: "",
      adicional: "",
      tipo_adicional: "",
      proprietario_id: "",
      obs: "",
      envio_boleto: "",
      created_at: "",
    },
    rules: {
      required: (value) => !!value || "*Obrigatório",
    },

    //Debitos
    debitos: [],
    headers: [
      { text: "Unidade", value: "unidade_id" },
      { text: "Tipo", value: "tipo" },
      { text: "Dt.Vencto", value: "dtvencto" },
      { text: "Valor", value: "valor" },
      { text: "Dt.Pagto", value: "dtpagto" },
      { text: "Vl.Pago", value: "valorpago" },
      { text: "Boleto", value: "boleto" },
      { text: "Vl.Devido", value: "valoratual" }, //confirmar se é esse valor msm
      { text: "", value: "action", sortable: false },
    ],
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
    this.buscaDebitos();
  },
  methods: {
    buscaDebitos() {
      this.debitos = [];
      axios
        .get("/api/debitos", { params: this.filtroItem })
        .then((response) => {
          this.tableData = response.data;
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
<style scooped></style>
