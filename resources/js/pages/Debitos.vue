<template>
  <div>
    <!--"Principal, não mudar"-->
    <v-container>
      <v-row justify="space-between">
        <v-col>
          <h3>Debitos</h3>
        </v-col>
        <v-col align="right">
          <v-dialog v-model="dialog" max-width="700px">
            <template #activator="form">
              <v-tooltip bottom>
                <template #activator="{ on, attrs }">
                  <v-btn icon v-bind="attrs" v-on="on">
                    <v-icon color="primary" v-on="form.on"
                      >mdi-plus-circle-outline</v-icon
                    >
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
                      <v-select
                        v-model="debito.unidade_id"
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
                      <v-radio-group
                        v-model="debito.tipo"
                        label="Tipo"
                        col
                        dense
                        :mandatory="true"
                      >
                        <v-radio label="Avulso" value="Avulso"></v-radio>
                        <v-radio
                          label="Mensalidade"
                          value="Mensalidade"
                        ></v-radio>
                        <v-radio label="Acordo" value="Acordo"></v-radio>
                        <v-radio label="Multa" value="Multa"></v-radio>
                      </v-radio-group>
                    </v-flex>
                    <v-flex v-if="debito.tipo == 'Mensalidade'" xs12>
                      <v-select
                        v-model="debito.taxa_id"
                        :items="allTaxas"
                        label="Taxa*"
                        item-text="anomes"
                        item-value="id"
                        outlined
                        return-value
                        :rules="[rules.required]"
                      ></v-select>
                    </v-flex>
                    <v-flex v-if="debito.tipo == 'Acordo'" xs12>
                      <v-text-field
                        v-model="debito.acordo_id"
                        v-mask="['######']"
                        outlined
                        label="Acordo"
                        :rules="[rules.required]"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                      <v-textarea
                        v-model="debito.obs"
                        label="Obs"
                        outlined
                      ></v-textarea>
                    </v-flex>
                    <v-flex xs12>
                      <v-menu
                        v-model="menu"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template #activator="{ on, attrs }">
                          <v-text-field
                            v-model="debito.dtvencto"
                            label="Vencimento"
                            outlined
                            v-bind="attrs"
                            :rules="[rules.required]"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="debito.dtvencto"
                          no-title
                          @input="menu = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-flex>
                    <v-flex xs12>
                      <v-currency-field
                        v-model="debito.valor"
                        label="Valor"
                        outlined
                        :rules="[rules.required]"
                      />
                    </v-flex>
                    <v-flex xs12>
                      <v-menu
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="290px"
                      >
                        <template #activator="{ on, attrs }">
                          <v-text-field
                            v-model="debito.dtpagto"
                            label="Pagamento"
                            outlined
                            v-bind="attrs"
                            :rules="[rules.required]"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="debito.dtpagto"
                          no-title
                          @input="menu2 = false"
                        ></v-date-picker>
                      </v-menu>
                    </v-flex>
                    <v-flex xs12>
                      <v-currency-field
                        v-model="debito.valorpago"
                        label="Valor Pago"
                        outlined
                        :rules="[rules.required]"
                      />
                    </v-flex>
                    <v-flex xs12>
                      <v-select
                        v-model="debito.remessa"
                        :items="allTiposRemessa"
                        label="Remessa*"
                        item-text="descricao"
                        item-value="id"
                        outlined
                        return-value
                        :rules="[rules.required]"
                      ></v-select>
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
          </v-dialog>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-select
            v-model="filtroItem.proprietario_id"
            :items="allProprietarios"
            label="Proprietários*"
            item-text="nome"
            item-value="id"
            outlined
            return-value
            dense
          ></v-select>
        </v-col>
        <v-col>
          <v-select
            v-model="filtroItem.unidade_id"
            :items="allUnidades"
            label="Unidades*"
            item-text="descricao"
            item-value="id"
            outlined
            return-value
            dense
          ></v-select>
        </v-col>
        <v-col>
          <v-select
            v-model="filtroItem.tipo_id"
            :items="allTiposDebitos"
            label="Tipo Débito*"
            item-text="descricao"
            item-value="id"
            outlined
            return-value
            dense
          ></v-select>
        </v-col>
      </v-row>

      <v-row>
        <v-col :cols="2">
          <v-menu
            v-model="menu3"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
          >
            <template #activator="{ on, attrs }">
              <v-text-field
                v-model="filtroItem.dtini"
                label="Data Inicial*"
                outlined
                v-bind="attrs"
                dense
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="filtroItem.dtini"
              no-title
              @input="menu3 = false"
            ></v-date-picker>
          </v-menu>
        </v-col>
        <v-col :cols="2">
          <v-menu
            v-model="menu4"
            :close-on-content-click="false"
            :nudge-right="40"
            transition="scale-transition"
            offset-y
          >
            <template #activator="{ on, attrs }">
              <v-text-field
                v-model="filtroItem.dtfim"
                label="Data Final*"
                outlined
                v-bind="attrs"
                dense
                v-on="on"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="filtroItem.dtfim"
              no-title
              @input="menu4 = false"
            ></v-date-picker>
          </v-menu>
        </v-col>
        <v-col :cols="4">
          <v-select
            v-model="filtroItem.condicao"
            :items="allCondicao"
            label="Condição*"
            item-text="descricao"
            item-value="id"
            outlined
            return-value
            dense
          ></v-select>
        </v-col>
        <v-col :cols="2">
          <v-spacer></v-spacer>
          <v-select
            v-model="filtroItem.envio_boleto"
            :items="allTiposEnvio"
            label="Tipo de Envio*"
            item-text="descricao"
            item-value="id"
            outlined
            return-value
            dense
          ></v-select>
        </v-col>
        <v-col :cols="2">
          <v-select
            v-model="filtroItem.ordem"
            :items="allOrdenacao"
            label="Ordenação da Listagem*"
            item-text="descricao"
            item-value="id"
            outlined
            return-value
            dense
          ></v-select>
        </v-col>
      </v-row>

      <v-row>
        <v-btn color="primary" @click="buscaDebitos()">Filtra</v-btn>
        <v-btn @click="boletosImpressos()">Boletos Impressos</v-btn>
        <v-btn @click="boletosEmail()">Boletos Email</v-btn>
        <v-btn @click="listagemDebitos()">Listagem</v-btn>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-row>
    </v-container>
    <v-data-table
      :headers="headers"
      :items="tableData"
      :search="search"
      fixed-header
      dense
      :must-sort="true"
      sort-by="unidade_id"
      class="elevation-1"
      :footer-props="{ 'items-per-page-options': [10, 20, 30, 40, 50] }"
      :items-per-page="30"
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
  </div>
</template>

<script>
import axios from "axios";
import { mdiBarcode } from "@mdi/js";
import jQuery from "jquery";
export default {
  data: () => ({
    mdiBarcode,
    menu: "",
    menu2: "",
    menu3: "",
    menu4: "",
    search: "",
    sortBy: "dtvencto",
    sortDesc: true,
    naoLocalizado: false,
    dialog: false,
    headers: [
      { text: "Unidade", value: "unidade_id" },
      { text: "Tipo", value: "tipo" },
      { text: "Dt.Vencto", value: "dtvencto" },
      { text: "Valor", value: "valor" },
      { text: "Dt.Pagto", value: "dtpagto" },
      { text: "Vl.Pago", value: "valorpago" },
      { text: "Boleto", value: "boleto" },
      { text: "Vl.Devido", value: "valoratual" }, //confirmar se é esse valor msm
      { text: "", value: "action", sortable: false }
    ],
    tableData: [],
    editedIndex: -1,
    allProprietarios: [{ id: "00", nome: "Todos" }],
    allUnidades: [{ id: "00", descricao: "Todos" }],
    allTiposDebitos: ["Todos", "Avulso", "Mensalidade", "Acordo", "Multa"],
    allCondicao: ["Ambos", "Abertos", "Pagos"],
    allTiposEnvio: ["Todos", "Impresso", "Email"],
    allTiposRemessa: [
      { id: "S", descricao: "Sim" },
      { id: "N", descricao: "Não" }
    ],
    allOrdenacao: ["Proprietário", "Unidade", "Pagamento", "Vencimento"],
    allTaxas: [{ id: "", anomes: "" }],
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
      created_at: ""
    },
    defaultItem: {
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
      created_at: ""
    },
    filtroItem: {
      proprietario_id: "",
      unidade_id: "",
      tipo_id: "",
      dtini: "",
      dtfim: "",
      condicao: "",
      envio_boleto: "",
      ordem: ""
    },
    rules: {
      required: value => !!value || "*Obrigatório"
    }
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "Novo Débito"
        : "Alteração/Baixa de Débito";
    }
  },

  watch: {
    dialog(val) {
      val || this.close();
    }
  },

  created() {
    this.initialize();
  },

  methods: {
    cleanData() {
      this.debito.dtvencto = "";
    },
    buscaDebitos() {
      this.tableData = [];
      axios
        .get("/api/debitos", { params: this.filtroItem })
        .then(response => {
          this.tableData = response.data;
        })
        .catch(error => console.log(error));
    },
    initialize() {
      axios
        .get("/api/proprietarios")
        .then(response => {
          this.allProprietarios = response.data;
          this.allProprietarios.sort();
          this.allProprietarios.unshift({ id: "00", nome: "Todos" });
        })
        .catch(error => console.log(error));

      axios
        .get("/api/unidades")
        .then(response => {
          this.allUnidades = response.data;
          this.allUnidades.sort();
          this.allUnidades.unshift({ id: "00", descricao: "Todos" });
        })
        .catch(error => console.log(error));

      axios
        .get("/api/taxas")
        .then(response => {
          this.allTaxas = response.data;
        })
        .catch(error => console.log(error));
      this.filtroItem.ordem = "Unidade";
      this.filtroItem.condicao = "Abertos";
      this.buscaDebitos();
    },

    editItem(item) {
      this.editedIndex = this.tableData.indexOf(item);
      this.debito = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      const index = this.tableData.indexOf(item);
      confirm("Você deseja apagar este item?") &&
        axios
          .delete("/api/debitos/" + item.id)
          .then(response => {
            console.log(response.data);
            this.tableData.splice(index, 1);
          })
          .catch(error => console.log(error));
    },

    close() {
      this.dialog = false;
      setTimeout(() => {
        this.debito = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },

    save() {
      if (this.editedIndex > -1) {
        axios
          .put("/api/debitos/" + this.debito.id, this.debito)
          .then(response => {
            console.log(response.data);
            Object.assign(this.tableData[this.editedIndex], this.debito);
            this.close();
          })
          .catch(error => console.log(error));
      } else {
        console.log(this.debito);
        axios
          .post("/api/debitos/", this.debito)
          .then(response => {
            console.log(response.data);
            this.tableData.push(this.debito);
            this.close();
          })
          .catch(error => console.log(error));
      }
    },
    unidadeDescricao(id) {
      return this.allUnidades.find(x => x.id == id)
        ? this.allUnidades.find(x => x.id == id).descricao
        : "";
    },
    boletosImpressos() {
      var url = "/financeiro/imprimirBoletos";
      url = url + "?" + jQuery.param(this.filtroItem);
      window.open(url, "_blank");
    },
    boletosImpressoUnico(item) {
      let url = "/financeiro/imprimirBoletos?debito_id=" + item.id;
      window.open(url, "_blank");
    },
    boletosEmail() {
      axios
        .get("/financeiro/emailBoletos", { params: this.filtroItem })
        .then(() => alert("Email enviado com sucesso."))
        .catch(error => console.log(error));
    },
    boletosEmailUnico(item) {
      axios
        .get("/financeiro/emailBoletos?debito_id=" + item.id)
        .then(() => alert("Email enviado com sucesso."))
        .catch(error => console.log(error));
    },
    listagemDebitos() {
      var url = "/financeiro/listagemDebitos";
      url = url + "?" + jQuery.param(this.filtroItem);
      window.open(url, "_blank");
    }
  }
};
</script>

<style scooped>
.debitos-table table th {
  font-size: 16px !important;
}
.col {
  padding: 2px;
}
.v-btn {
  text-transform: none;
  margin-left: 10px;
}
</style>
