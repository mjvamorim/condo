<template>
  <v-list dense>
    <v-list-group no-action prepend-icon="insert_drive_files">
      <template v-slot:activator>
        <v-list-item-title>Cadastros</v-list-item-title>
      </template>
      <v-list-item to="/admin/proprietarios">
        <v-list-item-action>
          <v-icon>person</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Proprietários</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/unidades">
        <v-list-item-action>
          <v-icon>house</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Unidades</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/debitos">
        <v-list-item-action>
          <v-icon>local_atm</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Débitos</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/taxas">
        <v-list-item-action>
          <v-icon>local_offer</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Taxas</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/acordos">
        <v-list-item-action>
          <v-icon>group</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Acordos</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-group>

    <!-- <v-list-group no-action prepend-icon="apartment">
      <template v-slot:activator>
        <v-list-item-title>Administração</v-list-item-title>
      </template>
      <v-list-item to="/admin/users">
        <v-list-item-action>
          <v-icon>account_circle</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Usuários</v-list-item-title>
        </v-list-item-content>
      </v-list-item> 
      <v-list-item to="/admin/empresas">
        <v-list-item-action>
          <v-icon>business_center</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Empresas</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-group> -->

    <v-list-group no-action prepend-icon="request_quote">
      <template v-slot:activator>
        <v-list-item-title>Rotinas Financeiras</v-list-item-title>
      </template>
      <v-list-item to="/admin/gerar_mensalidades">
        <v-list-item-action>
          <v-icon>credit_card</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Gerar Mensalidades</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/gerar_remessa">
        <v-list-item-action>
          <v-icon>save</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Gerar Remessa</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/baixas_bancarias">
        <v-list-item-action>
          <v-icon>compare_arrows</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Baixas Bancárias</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/acordo_novo">
        <v-list-item-action>
          <v-icon>group</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Fazer Acordo</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-group>

    <v-list-group no-action prepend-icon="settings">
      <template v-slot:activator>
        <v-list-item-title>Utilidades</v-list-item-title>
      </template>
      <v-list-item href="/manual" >
        <v-list-item-action>
          <v-icon>menu_book</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Manual do Usuário</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/log_baixas">
        <v-list-item-action>
          <v-icon>speed</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Log de Baixas</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-item to="/admin/emails_enviados">
        <v-list-item-action>
          <v-icon>email</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Emails Enviados</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list-group>
  </v-list>
</template>

<script>
export default {};
</script>

<style scoped>
.v-application--is-ltr
  .v-list-group--no-action
  > .v-list-group__items
  > .v-list-item {
  padding-left: 31px;
}
</style>
