<template>
  <v-card>
    <v-card-title>
      <span class="headline">Debito</span>
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
              <v-radio label="Mensalidade" value="Mensalidade"></v-radio>
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
            <v-textarea v-model="debito.obs" label="Obs" outlined></v-textarea>
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
                  :rules="[]"
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
</template>

<script>
import axios from "axios";
export default {
  props: {
    // eslint-disable-next-line vue/require-default-prop
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
      valoratual: "",
      created_at: ""
    }
  },
  emits: ["on-close", "on-save"],
  data: () => ({
    //Variavel menu controla a exibição da data no Datapicker
    menu: "",
    menu2: "",
    allUnidades: [{ id: "00", descricao: "Todos" }],
    allTiposDebitos: ["Todos", "Avulso", "Mensalidade", "Acordo", "Multa"],
    allTiposRemessa: [
      { id: "S", descricao: "Sim" },
      { id: "N", descricao: "Não" }
    ],
    allTaxas: [{ id: "", anomes: "" }],
    //debito: {},

    rules: {
      required: value => !!value || "*Obrigatório"
    }
  }),

  created() {
    // this.debito = Object.assign({}, this.debito);
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
  },

  methods: {
    close() {
      this.$emit("on-close");
    },

    save() {
      if (this.debito.id > 0) {
        axios
          .put("/api/debitos/" + this.debito.id, this.debito)
          .then(response => {
            console.log(response.data);
            this.$emit("on-save", this.debito);
            this.close();
          })
          .catch(error => console.log(error));
      } else {
        //console.log(this.debito);
        axios
          .post("/api/debitos/", this.debito)
          .then(response => {
            console.log(response.data);
            console.log(this.debito);
            this.$emit("on-save", this.debito);
            this.close();
          })
          .catch(error => console.log(error));
      }
    }
  }
};
</script>

<style scooped></style>
