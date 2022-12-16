import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Dashboard from "./pages/Dashboard";
import Users from "./pages/Users";
import Proprietarios from "./pages/Proprietarios";
import Unidades from "./pages/Unidades";
import UnidadesDetalhes from "./pages/UnidadeDetalhes/UnidadesDetalhes";
import Taxas from "./pages/Taxas";
import Debitos from "./pages/Debitos";
import Acordos from "./pages/Acordos/Acordos";
import AcordoNovo from "./pages/Acordos/AcordoNovo";
import GerarMensalidades from "./pages/GerarMensalidades";
import GerarRemessa from "./pages/GerarRemessa";
import EmailsEnviados from "./pages/EmailsEnviados";
import LogBaixas from "./pages/LogBaixas";
import BaixasBancarias from "./pages/BaixasBancarias";

const routes = [
  {
    path: "/admin/",
    component: Dashboard,
  },
  {
    path: "/admin/users",
    component: Users,
  },
  {
    path: "/admin/unidades",
    component: Unidades,
  },
  {
    path: "/admin/unidades_detalhes",
    name: "UnidadesDetalhes",
    component: UnidadesDetalhes,
  },
  {
    path: "/admin/proprietarios",
    component: Proprietarios,
  },
  {
    path: "/admin/taxas",
    component: Taxas,
  },
  {
    path: "/admin/debitos",
    component: Debitos,
  },
  {
    path: "/admin/acordos",
    component: Acordos,
  },
  {
    path: "/admin/acordo_novo",
    component: AcordoNovo,
  },
  {
    path: "/admin/gerar_mensalidades",
    component: GerarMensalidades,
  },
  {
    path: "/admin/gerar_remessa",
    component: GerarRemessa,
  },
  {
    path: "/admin/emails_enviados",
    component: EmailsEnviados,
  },
  {
    path: "/admin/log_baixas",
    component: LogBaixas,
  },
  {
    path: "/admin/baixas_bancarias",
    component: BaixasBancarias,
  },
];

const router = new VueRouter({
  mode: "history",
  routes,
});

export default router;
