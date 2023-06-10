<template>
  <div id="app">
    <div class="container-scroller">
      <router-view name="header" />
      <div class="container-fluid page-body-wrapper">
        <router-view name="sidebar" />
          <router-view/>
          
      </div> 
      <!-- <router-view name="footer" /> -->
    </div>
  </div>
</template>


