<template>
  <v-app id="inspire">
    <TopNavigation />
    <v-main style="background: #f5f5f5">
      <v-container class="py-8 px-6" fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import TopNavigation from "./components/TopNavigation";

export default {
  name: "App",
  components: {TopNavigation},
  data: () => ({}),
  methods: {},
}
</script>
