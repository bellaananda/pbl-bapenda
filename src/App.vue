<template>
  <div id="app">
    <div class="container-scroller">
      <router-view name="header" />
      <div class="container-fluid page-body-wrapper">
        <router-view name="sidebar" />
          <router-view/>
          
      </div> 
      <router-view name="footer" />
    </div>
  </div>
</template>

<!-- <script>

export default {
	name: "App",
  computed : {
        isLoggedIn : function(){ return this.$store.getters.isLoggedIn;},
        email : function(){ return this.$store.getters.userDetail.email;},
        role : function(){ return this.$store.getters.userDetail.role;}
    },

};
</script> -->

