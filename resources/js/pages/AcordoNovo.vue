<template>
  <v-card min-height="600px" style="padding: 10px">
    <h3>Novo Acordo</h3>
    <v-tabs v-model="tab" dense dark>
      <v-tabs-slider></v-tabs-slider>
      <v-tab>Identificação</v-tab>
      <v-tab>Prestações Devidas</v-tab>
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
                  <v-select
                    v-model="editedItem.unidade_id"
                    :items="allUnidades"
                    label="Unidades*"
                    item-text="descricao"
                    item-value="id"
                    outlined
                    return-value
                    dense
                    @change="buscaDebitos()"
                    :rules="[rules.required]"
                  ></v-select>
                </v-flex>
                <v-flex xs12>
                  <v-menu
                    v-model="menuData"
                    :close-on-content-click="false"
                    :nudge-right="40"
                    transition="scale-transition"
                    offset-y
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        v-model="editedItem.data"
                        label="Data Inicial*"
                        outlined
                        v-bind="attrs"
                        v-on="on"
                        dense
                        :rules="[rules.required]"
                      ></v-text-field>
                    </template>
                    <v-date-picker v-model="editedItem.data" @input="menuData = false" no-title></v-date-picker>
                  </v-menu>
                </v-flex>

                <v-flex xs12>
                  <v-textarea
                    v-model="editedItem.termos"
                    outlined
                    label="Termos"
                    :rules="[rules.required]"
                  ></v-textarea>
                </v-flex>
              </v-layout>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="danger" outlined text @click>Retornar</v-btn>
            <v-btn color="primary" outlined text @click="tab=1">Próximo</v-btn>
          </v-card-actions>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <h4>Composição</h4>
            <v-data-table
              :headers="headers"
              :items="tableDataComposicao"
              fixed-header
              dense
              disable-pagination
              :must-sort="true"
              sort-by="dtvencto"
              hide-default-footer
              class="elevation-1"
              show-select
              v-model="editedItem.debitosSelecionados"
            >
              <template v-slot:item.unidade_id="{ item }">
                {{
                unidadeDescricao(item.unidade_id)
                }}
              </template>

              <template v-slot:item.valor="{ item }">
                <div class="text-right">R$ {{item.valor ? item.valor.toFixed(2) : '0,00'}}</div>
              </template>
              <template v-slot:item.valorpago="{ item }">
                <div class="text-right">{{item.valorpago ? 'R$' + item.valorpago.toFixed(2): ''}}</div>
              </template>
              <template v-slot:item.valoratual="{ item }">
                <div class="text-right">R$ {{item.valoratual.toFixed(2)}}</div>
              </template>
            </v-data-table>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="danger" outlined text @click="tab=0">Anterior</v-btn>
            <v-btn color="primary" outlined text @click="tab=2; totaliza();">Próximo</v-btn>
          </v-card-actions>
        </v-card>
      </v-tab-item>

      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <h4>Prestações</h4>
            <v-container style="max-width:800px;">
              <v-row>
                <v-col style="max-width:30%;">
                  <v-flex>
                    <v-select
                      v-model="parcelamento.frequencia"
                      :items="['Anual','Semestral','Mensal','Quinzenal','Semanal',]"
                      label="Frequencia*"
                      outlined
                      dense
                      @change="buscaDebitos()"
                    ></v-select>
                  </v-flex>
                  <v-flex>
                    <v-menu
                      v-model="menuDtInicial"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                    >
                      <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                          v-model="parcelamento.dtInicial"
                          label="Data Inicial*"
                          outlined
                          v-bind="attrs"
                          v-on="on"
                          dense
                          :rules="[rules.required]"
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="parcelamento.dtInicial"
                        @input="menuDtInicial = false"
                        no-title
                      ></v-date-picker>
                    </v-menu>
                  </v-flex>

                  <v-flex>
                    <v-text-field
                      v-model="parcelamento.qtde"
                      v-mask="['##']"
                      :rules="[rules.required]"
                      outlined
                      label="Qtde Parcelas"
                    ></v-text-field>
                  </v-flex>
                  <v-flex>
                    <v-currency-field
                      label="Valor da Parcela"
                      outlined
                      v-model="parcelamento.valor"
                      :rules="[rules.required]"
                    />
                  </v-flex>

                  <v-spacer></v-spacer>

                  <v-btn color="primary" outlined text @click="gerarParcelas()">Gerar Parcelas</v-btn>
                </v-col>
                <v-col style="padding-left:25px">
                  <v-data-table
                    :headers="headersPrestacoes"
                    :items="editedItem.prestacoes"
                    fixed-header
                    dense
                    disable-pagination
                    :items-per-page=100
                    :must-sort="true"
                    sort-by="dtvencto"
                    hide-default-footer
                    class="elevation-1"
                  >
                    <template v-slot:item.valor="{ item }">
                      <div class="text-right">{{item.valor ? 'R$' +item.valor.toFixed(2) : ''}}</div>
                    </template>
                    <template v-slot:item.action="{ item }">
                      <v-icon small @click="deleteItem(item)">delete</v-icon>
                    </template>
                  </v-data-table>
                  <v-container>
                    <v-btn color="danger" outlined text @click="totaliza()">Totaliza</v-btn>
                    <v-flex xs-12>
                      <h6>Total Devido : R$ {{totDebitos ? totDebitos.toFixed(2) : '0.00'}}</h6>
                    </v-flex>

                    <v-flex xs-12>
                      <h6>Total Acordo: R$ {{totPrestacoes ? totPrestacoes.toFixed(2) : '0.00'}}</h6>
                    </v-flex>
                  </v-container>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="danger" outlined text @click="tab=1">Anterior</v-btn>
            <v-btn color="primary" outlined text @click="gerarAcordo()">Gerar Acordo</v-btn>
          </v-card-actions>
        </v-card>
      </v-tab-item>
    </v-tabs-items>
  </v-card>
</template>


<script>
export default {
  name: "acordoNovo",
  props: ["unidade_id"],
  data: () => ({
    tab: 0,
    menuDtInicial: null,
    menuData: null,
    rules: {
      required: (value) => !!value || "*Obrigatório",
    },
    headers: [
      { text: "Unidade", value: "unidade_id" },
      { text: "Tipo", value: "tipo" },
      { text: "Dt.Vencto", value: "dtvencto" },
      { text: "Valor", value: "valor" },
      // { text: "Dt.Pagto", value: "dtpagto" },
      // { text: "Vl.Pago", value: "valorpago" },
      // { text: "Boleto", value: "boleto" },
      { text: "Vl.Devido", value: "valoratual" },
      // { text: "Acordo", value: "acordo_quitacao_id" }, //confirmar se é esse valor msm
      { text: "", value: "action", sortable: false },
    ],
    headersPrestacoes: [
      { text: "Dt.Vencto", value: "vencto" },
      { text: "Valor", value: "valor" },
      { text: "Ações", value: "action", sortable: false },
    ],

    tableDataComposicao: [],
    prestacoes: [],
    allUnidades: [],
    filtro: {
      unidade_id: "",
      condicao: "Abertos",
    },
    editedItem: {
      unidade_id: 0,
      data: "",
      termos: "",
      debitosSelecionados: [],
      prestacoes: [],
    },
    parcelamento: {
      frequencia: "Mensal",
      dtInicial: "",
      qtde: 1,
      valor: 0.0,
    },

    totDebitos: 0,
    totPrestacoes: 0,
  }),

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      this.editedItem.unidade_id = this.unidade_id;
      axios
        .get("/api/unidades")
        .then((response) => {
          this.allUnidades = response.data;
          this.allUnidades.sort();
        })
        .catch((error) => console.log(error));
    },
    unidadeDescricao(id) {
      return this.allUnidades.find((x) => x.id == id)
        ? this.allUnidades.find((x) => x.id == id).descricao
        : "";
    },
    buscaDebitos() {
      this.filtro.unidade_id = this.editedItem.unidade_id;
      this.tableDataComposicao = [];
      axios
        .get("/api/debitos", { params: this.filtro })
        .then((response) => {
          this.tableDataComposicao = response.data;
        })
        .catch((error) => console.log(error));
    },
    totaliza() {
      //totDebitos
      this.totDebitos = 0;
      if (this.editedItem.debitosSelecionados) {
        this.editedItem.debitosSelecionados.forEach((element) => {
          this.totDebitos += element.valoratual;
        });
      }

      //totPrestacoes
      this.totPrestacoes = 0;
      this.editedItem.prestacoes.forEach((element) => {
           this.totPrestacoes += element.valor;
      });
    },
    gerarParcelas() {
      var dtvencto = new Date(this.parcelamento.dtInicial+"T12:00:00");
      var day = dtvencto.getDate(); //
      var month = dtvencto.getMonth() + 1;
      var year = dtvencto.getFullYear();
      var valor = this.parcelamento.valor;
      if (!(day && month && year && valor)) {
        alert('Data ou valor não preenchidos!')
      }
      else {
        for(let i=1;i<=this.parcelamento.qtde;i++) {
          let dt = this.pad(year,4)+'-'+this.pad(month,2)+'-'+this.pad(day,2);
          this.editedItem.prestacoes.push({vencto: dt, valor: valor});

          switch(this.parcelamento.frequencia) {
            case 'Anual' : 
              year = year + 1;
              break;
            case 'Semestral' : 
              month = month + 6;
              break;
            case 'Quinzenal' : 
              day = day + 15;
              break;
            case 'Semanal' : 
              day = day + 7;
              break;
            default:
              month = month + 1;
          } 

          dtvencto = new Date(year,month - 1,day);
          day = dtvencto.getDate(); //
          month = dtvencto.getMonth() + 1;
          year = dtvencto.getFullYear();
          
        }
        this.parcelamento.frequencia= "Mensal";
        this.parcelamento.qtde= 1;
        this.parcelamento.valor= 0.0;   
        alert('Parcelas Geradas!');
      }
      this.totaliza();  

    },
    gerarAcordo() {
      if (!this.editedItem.unidade_id) {
        alert('Unidade não preenchida!');
        this.tab = 0;
        return;
      }
      if (!this.editedItem.data){
        alert('Data do acordo nao preenchida!');
        this.tab = 0;
        return;
      }
      if (!this.editedItem.termos){
        alert('Termos do acordo nao preenchida!');
        this.tab = 0;
        return;
      }
      if (!this.editedItem.debitosSelecionados.length){
        alert('Acordo sem composição!');
        this.tab = 1;
        return;
      }
      if (!this.editedItem.prestacoes.length){
        alert('Acordo sem prestações!');
        this.tab = 2;
        return;
      }
      confirm("Você deseja gerar este acordo?") &&
        axios
          .post("/api/gerarAcordo/", this.editedItem)
          .then((response) => {
            alert('Acordo Gerado com sucesso!');
            this.editedItem.unidade_id= 0;
            this.editedItem.data= "";
            this.editedItem.termos= "";
            this.tableDataComposicao = [];
            this.editedItem.prestacoes= [];
            this.totaliza();
            this.tab = 0;
            console.log(response.data);
          })
          .catch((error) => console.log(error));
    },
    pad(num, size) {
      num = num.toString();
      while (num.length < size) num = "0" + num;
      return num;
    },
    deleteItem(item) {
      const index = this.editedItem.prestacoes.indexOf(item);
      this.editedItem.prestacoes.splice(index, 1);
      this.totaliza();   
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

