<template>
   
  <div class="container-scroller">
    <!-- navbar -->
    <Navbar />
    <div class="container-fluid page-body-wrapper">
      <Sidebar />
      <div class="main-panel">
        <router-view/>
        <!-- footer  -->
        <Footer />
      </div>
    </div>   
  </div>
</template>

<script>
import Footer from "./components/TheFooter.vue";
import Navbar from "./components/TheNavbar.vue";
import Sidebar from "./components/TheSidebar.vue";

export default {
  name: "App",
  components: {
    Footer,
    Navbar,
    Sidebar,
  },
};
</script>

