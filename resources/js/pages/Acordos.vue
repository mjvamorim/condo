<template>
  <div>
    <!--"Principal, não mudar"-->
    <v-container>
      <v-row justify="space-between">
        <v-col>
          <h3>Acordos</h3>
        </v-col>
        <v-col align="right">

          <a :href="'/admin/acordo_novo'">
              <v-icon color="primary">mdi-plus-circle-outline</v-icon>
          </a>

            
          <v-dialog v-model="dialog" max-width="1200px">
            <!--Formulario-->
            <AcordoDetalhes ref="AcordoDetalhes" :acordo="item" :allUnidades="allUnidades"></AcordoDetalhes>
          </v-dialog>
        </v-col>
      </v-row>

      <v-row>
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
            @change="buscaAcordos()"
          ></v-select>
        </v-col>
      </v-row>
    </v-container>
    <v-data-table
      :headers="headers"
      :items="tableData"
      :search="search"
      :items-per-page=15
      dense
      fixed-header
      :must-sort="true"
      sort-by="unidade_id"
      class="elevation-1 acordos-table"
    >
      <template v-slot:item.unidade_id="{ item }">
        {{
        unidadeDescricao(item.unidade_id)
        }}
      </template>
      <template v-slot:item.action="{ item }">
        <v-icon small @click="show(item)">pageview_outline</v-icon>
        <!-- <v-icon small @click="deleteItem(item)">delete</v-icon> -->
      </template>
    </v-data-table>
  </div>
</template>

<script lang="js">
import AcordoDetalhes from "./AcordoDetalhes";
export default {
  components: { AcordoDetalhes },
  data: () => ({
    search: "",
    item: "",
    dialog: false,
    headers: [
      { text: "Id", value: "id" },
      { text: "Unidade", value: "unidade_id" },
      { text: "data", value: "data" },
      { text: "Situação", value: "situacao" },
      { text: "Ações", value: "action", sortable: false },
    ],
    tableData: [],
    allUnidades: [{ id: "00", descricao: "Todos" }],
    filtroItem: {
      unidade_id: "",
    },
  }),

  computed: {
    formTitle() {
      return "Acordo: " + this.item.id;
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
    buscaAcordos() {
      this.tableData = [];
      axios
        .get("/api/acordos", { params: this.filtroItem })
        .then((response) => {
          this.tableData = response.data;
        })
        .catch((error) => console.log(error));
    },
    initialize() {
      axios
        .get("/api/unidades")
        .then((response) => {
          this.allUnidades = response.data;
          this.allUnidades.sort();
          this.allUnidades.unshift({ id: "00", descricao: "Todos" });
        })
        .catch((error) => console.log(error));
      this.buscaAcordos();
    },

    show(item) {
      this.item = item;

      this.dialog = true;
      //this.$refs.AcordoDetalhes.$mount;
      setTimeout(() => {
        this.$refs.AcordoDetalhes.buscaTermosAcordo(item.id);
        this.$refs.AcordoDetalhes.tab = 0;
      }, 100);

      //this.$refs.AcordoDetalhes.$forceUpdate();
    },

    close() {
      this.dialog = false;
    },

    unidadeDescricao(id) {
      return this.allUnidades.find((x) => x.id == id)
        ? this.allUnidades.find((x) => x.id == id).descricao
        : "";
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
</style>
