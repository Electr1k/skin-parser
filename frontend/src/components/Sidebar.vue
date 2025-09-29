<template>
  <v-navigation-drawer v-model="internalDrawer" app :width="280"
  >
    <v-img
        class="pa-4"
    >
      <div class="text-center">
        <v-avatar class="mb-2" color="grey darken-1" size="90">
          <v-img
              aspect-ratio="30"
              :src=this.image
          />
        </v-avatar>
        <h2 class="black--text">Aboba</h2>
        <v-btn text color="red" x-small @click="logout">Выйти</v-btn>
      </div>
    </v-img>
    <v-divider></v-divider>
    <v-list>
      <v-list-item
          v-for="(item, index) in main_links"
          :key="index"
          link
          :to="{ name: item.route }"
          active-class="primary--text"
          :exact="item.route === 'dashboard'"
      >
        <v-list-item-icon>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>{{ item.text }}</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <v-list-group
          prepend-icon="mdi-truck-delivery"
          value="false"
          active-class="primary--text"
      >
        <template v-slot:activator>
          <v-list-item-title>Достависта</v-list-item-title>
        </template>

        <v-list-item
            v-for="(item, index) in dostavista_links"
            :key="index"
            link
            :to="{ name: item.route }"
            active-class="primary--text"
            class="pl-8"
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import router from "@/router";

export default {
  name: "TheSidebar",
  props: {
    drawer: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      user_name: '',
      image: '',
      main_links: [
        { icon: "mdi-view-dashboard-outline", text: "Главная", route: "dashboard" },
        { icon: "mdi-security", text: "Роли", route: "roles" },
        { icon: "mdi-account-box", text: "Сотрудники", route: "users" },
      ],
      dostavista_links: [
        { icon: "mdi-certificate", text: "Кабинеты партнеров", route: "cabinets" },
        { icon: "mdi-card-account-details-outline", text: "Клиенты", route: "couriers" },
        { icon: "mdi-clipboard-list-outline", text: "Регистрации", route: "registrations" },
        { icon: "mdi-account-minus-outline", text: "Неактивные клиенты", route: "inactive-couriers" },
        { icon: "mdi-book-open-variant", text: "Сводный отчет", route: "summary" },
      ],
    };
  },
  async created() {
    await this.init()
  },
  methods: {
    async init() {

    },
    logout() {
      localStorage.removeItem('auth_token')
      router.push({ name: 'login'})
    }
  },
  computed: {
    internalDrawer: {
      get() {
        return this.drawer;
      },
      set(value) {
        this.$emit('update:drawer', value);
      }
    }
  }
};
</script>
