<template>
  <div class="">
    <!-- Responsive navbar-->
    <Navbar />
    <!-- Page header with logo and tagline-->
    <header class="py-5 bg-light border-bottom mb-4">
      <div class="container">
        <div class="text-center my-5">
          <h1 class="fw-bolder">Welcome to Library!</h1>
        </div>
      </div>
    </header>
    <!-- Page content-->
    <div class="container">
      <div class="row">
        <slot />
      </div>
    </div>
    <Footer />
  </div>
</template>

<script>
import Navbar from "./Navbar.vue";
import Footer from "./Footer.vue";

export default {
  name: "HomeComponent",
  components: {
    Navbar,
    Footer,
  },
};
</script>

<style>
</style>