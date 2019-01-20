<template>
  <div class="app">
    <Header fixed>
      <SidebarToggler class="d-lg-none" display="md" mobile />
      <b-link class="navbar-brand" to="#">
        CilegonSmartCity
      </b-link>
      <SidebarToggler class="d-md-down-none" display="lg" />
      <b-navbar-nav class="ml-auto">
        <Account />
      </b-navbar-nav>
    </Header>
    <div class="app-body">
      <Sidebar fixed>
        <SidebarNav :navItems="nav"></SidebarNav>
        <SidebarMinimizer />  
      </Sidebar>
      <main class="main">
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
    </div>
    <Footer>
      <div>
        <a href="https://coreui.io">CilegonSmartCity</a>
        <span class="ml-1">&copy; 2018. All Right Reserved.</span>
      </div>
      <div class="ml-auto">
        <span class="mr-1">Powered by</span>
        <a href="https://coreui.io">CoreUI for Vue</a>
      </div>
    </Footer>
  </div>
</template>

<script>

import nav from '../../_nav'
import { Header, SidebarToggler, Sidebar, SidebarNav, SidebarMinimizer, Footer, Breadcrumb } from '@coreui/vue'
import Account from './Account'

export default {
  name: 'Layout',
  components: {
    Account,
    Header,
    SidebarToggler,
    Sidebar,
    SidebarNav,
    SidebarMinimizer,
    Footer,
    Breadcrumb
  },
  data () {
    return {
      nav: nav.items
    }
  }
}

</script>
