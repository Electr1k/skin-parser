<template>
  <v-app-bar app flat class="top-navigation" height="80">
    <v-container class="px-4">
      <v-row align="center" class="mx-0">
        <!-- Логотип -->
        <v-col cols="auto" class="pr-8">
          <div class="logo">
            <span class="logo-text">SkinFinder</span>
          </div>
        </v-col>

        <!-- Навигационные вкладки -->
        <v-col>
          <div class="nav-tabs">
            <router-link
                v-for="(tab, index) in tabs"
                :key="index"
                :to="{ name: tab.route }"
                class="nav-tab"
                active-class="nav-tab--active"
                exact
            >
              <div class="nav-tab-content">
                <v-icon small class="nav-tab-icon">{{ tab.icon }}</v-icon>
                <span class="nav-tab-text">{{ tab.text }}</span>
              </div>
            </router-link>
          </div>
        </v-col>

        <!-- Профиль пользователя -->
        <v-col cols="auto">
          <div class="user-menu-wrapper">
            <v-menu bottom left offset-y>
              <template v-slot:activator="{ on, attrs }">
                <button class="user-button" v-bind="attrs" v-on="on">
                  <div class="user-avatar">
                    <img :src="image" alt="User" class="avatar-image" v-if="image">
                    <div class="avatar-placeholder" v-else>
                      <v-icon small color="#666">mdi-account</v-icon>
                    </div>
                  </div>
                  <span class="user-name">Aboba</span>
                  <svg class="chevron-icon" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  </svg>
                </button>
              </template>

              <v-card class="user-dropdown">
                <v-list class="py-2">
                  <v-list-item class="user-info">
                    <v-list-item-avatar class="mr-3">
                      <img :src="image" alt="User" v-if="image">
                      <v-icon v-else>mdi-account</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                      <v-list-item-title class="user-dropdown-name">Aboba</v-list-item-title>
                      <v-list-item-subtitle class="user-dropdown-role">Пользователь</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>

                <v-divider></v-divider>

                <v-list class="py-2">
                  <v-list-item @click="logout" class="logout-item">
                    <v-list-item-icon class="mr-3">
                      <v-icon small>mdi-logout</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="logout-text">Выйти</v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-menu>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-app-bar>
</template>

<script>
import router from "@/router";

export default {
  name: "TopNavigation",
  data() {
    return {
      image: '', // Заглушка для аватара
      tabs: [
        { icon: "mdi-home", text: "Главная", route: "dashboard" },
        { icon: "mdi-magnify", text: "Поиск скинов", route: "skin-search" },
        { icon: "mdi-checkbox-multiple-marked", text: "Найденные скины", route: "found-skins" },
        { icon: "mdi-cog", text: "Настройки", route: "settings" }
      ]
    };
  },
  methods: {
    logout() {
      localStorage.removeItem('auth_token')
      router.push({ name: 'login'})
    }
  }
};
</script>

<style scoped>
.top-navigation {
  background: #ffffff !important;
  border-bottom: 1px solid #e1e5e9;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

.logo-text {
  font-size: 1.5rem;
  font-weight: 700;
  color: #2c3e50;
  letter-spacing: -0.5px;
}

.nav-tabs {
  display: flex;
  gap: 8px;
  align-items: center;
}

.nav-tab {
  display: flex;
  align-items: center;
  padding: 8px 16px;
  border-radius: 8px;
  text-decoration: none;
  color: #666;
  font-weight: 500;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  border: 1px solid transparent;
}

.nav-tab:hover {
  background: #f8f9fa;
  color: #333;
}

.nav-tab--active {
  background: #f0f7ff;
  color: #1976d2;
  border-color: #e3f2fd;
}

.nav-tab-content {
  display: flex;
  align-items: center;
  gap: 8px;
}

.nav-tab-icon {
  margin-right: 4px;
}

.nav-tab-text {
  white-space: nowrap;
}

/* Стили для кнопки пользователя */
.user-button {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 8px 12px;
  border: 1px solid #e1e5e9;
  border-radius: 8px;
  background: #ffffff;
  color: #333;
  cursor: pointer;
  transition: all 0.2s ease;
  text-decoration: none;
}

.user-button:hover {
  background: #f8f9fa;
  border-color: #ccc;
}

.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 6px;
  overflow: hidden;
  background: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
}

.avatar-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.avatar-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #e9ecef;
}

.user-name {
  font-weight: 500;
  font-size: 0.9rem;
  color: #333;
}

.chevron-icon {
  transition: transform 0.2s ease;
  color: #666;
}

.user-button[aria-expanded="true"] .chevron-icon {
  transform: rotate(180deg);
}

/* Стили для выпадающего меню */
.user-dropdown {
  border-radius: 8px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  border: 1px solid #e1e5e9;
  min-width: 200px;
}

.user-info {
  padding: 12px 16px;
}

.user-dropdown-name {
  font-weight: 600;
  color: #333;
  font-size: 0.95rem;
}

.user-dropdown-role {
  color: #666;
  font-size: 0.8rem;
}

.logout-item {
  padding: 8px 16px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

.logout-item:hover {
  background: #f8f9fa;
}

.logout-text {
  color: #dc3545;
  font-weight: 500;
  font-size: 0.9rem;
}
</style>
