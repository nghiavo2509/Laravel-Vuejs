<template>
  <Sidebar />
  <div id="right-panel" class="right-panel">
    <Navbar />
    <Breadcrumb />
    <div class="content">
      <slot />
    </div>
    <Footer />
  </div>
</template>

<script>
import Sidebar from "./inc/Sidebar.vue";
import Navbar from "./inc/Navbar.vue";
import Footer from "./inc/Footer.vue";
import Breadcrumb from "./inc/Breadcrumb.vue";

export default {
  name: "DefaultComponent",
  components: {
    Navbar,
    Sidebar,
    Footer,
    Breadcrumb,
  },
};
</script>

<style>
</style>