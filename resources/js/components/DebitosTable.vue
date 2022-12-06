<template>
  <v-card flat>
    <v-tooltip bottom>
      <template #activator="{ on, attrs }">
        <v-fab-transition>
          <v-btn
            fab
            top
            absolute
            right
            outlined
            small
            color="primary"
            v-bind="attrs"
            v-on="on"
          >
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </v-fab-transition>
      </template>
      <span>Cadastrar novo débito avulso</span>
    </v-tooltip>

    <v-dialog v-model="showForm" max-width="600">
      <DebitosForm :debito="debito" @on-close="closeForm" @on-save="saveForm" />
    </v-dialog>
    <v-card-text>
      <v-data-table
        :headers="headers"
        :items="debitos"
        :search="search"
        fixed-header
        dense
        :items-per-page="15"
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
          <div class="text-right">R$ {{ item.valoratual.toFixed(2) }}</div>
        </template>
      </v-data-table>
    </v-card-text>
  </v-card>
</template>

<script>
import axios from "axios";
import { mdiBarcode } from "@mdi/js";
import DebitosForm from "./DebitosForm.vue";
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
    allUnidades: [{ id: "00", descricao: "Todos" }],
    showForm: false,
    debito: {
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
      valoratual: "",
      created_at: "",
    },
    index: 0,
  }),
  created() {
    console.log(this.unidade_id);
    axios
      .get("/api/unidades")
      .then((response) => {
        this.allUnidades = response.data;
        this.allUnidades.sort();
        this.allUnidades.unshift({ id: "00", descricao: "Todos" });
      })
      .catch((error) => console.log(error));
    this.buscaDebitos();
  },
  methods: {
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
    buscaDebitos() {
      this.filtroItem.unidade_id = this.unidade_id;
      console.log(this.filtroItem);
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
<style scooped></style>
