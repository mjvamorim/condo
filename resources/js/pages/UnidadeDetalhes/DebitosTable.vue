<template>
  <v-card flat>
    <v-card-title>
      <v-tooltip bottom>
        <template #activator="{ on, attrs }">
          <v-fab-transition>
            <v-btn
              fab
              top
              right
              outlined
              small
              color="primary"
              v-bind="attrs"
              v-on="on"
              @click="newItem(debito)"
            >
              <v-icon>mdi-plus</v-icon>
            </v-btn>
          </v-fab-transition>
        </template>
        <span>Cadastrar novo débito avulso</span>
      </v-tooltip>
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Buscar"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title>

    <v-card-text>
      <v-dialog v-model="showForm" max-width="600">
        <DebitosForm
          :debito="debito"
          @on-close="closeForm"
          @on-save="saveForm"
        />
      </v-dialog>

      <v-data-table
        :headers="headers"
        :items="debitos"
        :search="search"
        fixed-header
        dense
        :must-sort="true"
        sort-by="dtvencto"
        sort-desc
        class="elevation-1"
        :items-per-page="20"
        :footer-props="{ 'items-per-page-options': [10, 20, 30, 40, -1] }"
        @click:row="editItem"
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
              <v-icon small v-bind="attrs" @click="deleteItem(item)" v-on="on"
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
          <div v-if="item.valoratual" style="color: red" class="text-right">
            R$ {{ item.valoratual.toFixed(2) }}
          </div>
          <div v-else class="text-right">
            R$ {{ item.valoratual.toFixed(2) }}
          </div>
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from "axios";
import { mdiBarcode } from "@mdi/js";
import DebitosForm from "./DebitoForm.vue";
export default {
  components: { DebitosForm },
  // eslint-disable-next-line vue/prop-name-casing
  props: ["unidade_id"],
  data: () => ({
    //Debitos
    mdiBarcode,
    debitos: [],
    headers: [
      { text: "Unidade", value: "unidade_id" },
      { text: "Tipo", value: "tipo" },
      { text: "Dt.Vencto", value: "dtvencto" },
      { text: "Valor", value: "valor" },
      { text: "Dt.Pagto", value: "dtpagto" },
      { text: "Vl.Pago", value: "valorpago" },
      { text: "Boleto", value: "boleto" },
      { text: "Vl.Devido", value: "valoratual" },
      { text: "", value: "action", sortable: false },
    ],
    search: "",
    filtroItem: {
      proprietario_id: "",
      unidade_id: "",
      tipo_id: "",
      dtini: "",
      dtfim: "",
      condicao: "",
      envio_boleto: "",
      ordem: "",
    },
    allUnidades: [],
    showForm: false,
    debito: {
      id: 0,
      unidade_id: "",
      tipo: "",
      obs: "",
      taxa_id: "",
      acordo_id: "",
      dtvencto: "",
      valor: "",
      dtpagto: "",
      valorpago: "",
      remessa: "",
      boleto: "",
      acordo_quitacao_id: "",
      valoratual: 0,
      created_at: "",
    },
    index: 0,
  }),
  created() {
    //console.log(this.unidade_id);
    axios
      .get("/api/unidades")
      .then((response) => {
        this.allUnidades = response.data;
        this.allUnidades.sort();
      })
      .catch((error) => console.log(error));
    this.buscaDebitos();
  },
  methods: {
    buscaDebitos() {
      this.filtroItem.unidade_id = this.unidade_id;
      //console.log(this.filtroItem);
      axios
        .get("/api/debitos", { params: this.filtroItem })
        .then((response) => {
          this.debitos = response.data;
        })
        .catch((error) => console.log(error));
    },
    unidadeDescricao(id) {
      return this.allUnidades.find((x) => x.id == id)
        ? this.allUnidades.find((x) => x.id == id).descricao
        : "";
    },
    closeForm() {
      this.showForm = false;
    },
    saveForm(debito) {
      if (debito.id > 0) {
        Object.assign(this.debitos[this.index], debito);
      } else {
        this.debitos.push(debito);
      }
      this.showForm = false;
    },
    newItem() {
      this.debito.id = 0;
      this.debito.unidade_id = +this.unidade_id;
      this.debito.tipo = "Avulso";
      this.debito.obs = "";
      this.debito.taxa_id = "";
      this.debito.acordo_id = "";
      this.debito.dtvencto = ""; //Colocar
      this.debito.valor = 0;
      this.debito.dtpagto = "";
      this.debito.valorpago = "";
      this.debito.remessa = "N";
      this.debito.boleto = "";
      this.debito.acordo_quitacao_id = "";
      this.debito.valoratual = 0;
      this.debito.created_at = "";
      this.debito.remessa = "N";

      this.showForm = true;
    },
    editItem(item) {
      this.index = this.debitos.indexOf(item);
      this.debito = Object.assign({}, item);
      this.showForm = true;
    },
    deleteItem(item) {
      const index = this.debitos.indexOf(item);
      confirm("Você deseja apagar este item?") &&
        axios
          .delete("/api/debitos/" + item.id)
          .then((response) => {
            console.log(response.data);
            this.debitos.splice(index, 1);
          })
          .catch((error) => console.log(error));
    },
    boletosImpressoUnico(item) {
      let url = "/financeiro/imprimirBoletos?debito_id=" + item.id;
      window.open(url, "_blank");
    },
    boletosEmailUnico(item) {
      axios
        .get("/financeiro/emailBoletos?debito_id=" + item.id)
        .then(() => alert("Email enviado com sucesso."))
        .catch((error) => console.log(error));
    },
  },
};
</script>
<style scooped>
valoratual {
  color: red;
}
</style>
