<template>
  <v-container>
    <SearchBar
        v-model="searchQuery"
        :showDropdown.sync="showDropdown"
        :items="skins"
        @add-click="handleAddClick"
        @item-selected="handleItemSelected"
        @search-focus="handleSearchFocus"
    />

    <v-row>
      <v-col
          v-for="(item, index) in skinSettings"
          :key="index"
          cols="12"
      >
        <v-card
            class="d-flex align-center pa-4 shadow-card clickable-card"
            height="120px"
            @click="openDialog(item)"
            :ripple="false"
        >
          <v-img
              :src="item.icon"
              max-width="80"
              class="rounded-lg mr-4"
              height="100%"
          ></v-img>

          <v-card-text class="flex-grow-1 d-flex flex-column justify-center pa-0">
            <div class="font-weight-bold text-h6 mb-2">{{ item.market_name }}</div>
            <div class="d-flex align-center justify-space-between">
              <div class="d-flex indicators">
                <span class="indicator-limit">Предельный: <strong>{{ item.float_limit }}</strong></span>
                <span class="indicator-max">Максимальная цена: <strong>{{ item.max_price }}</strong></span>
                <span class="indicator-extremum">Направление: <strong>{{ item.extremum }}</strong></span>
              </div>
              <v-icon :color="item.is_active ? 'green' : 'red'" large>
                {{ item.is_active ? 'mdi-check-circle' : 'mdi-close-circle' }}
              </v-icon>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <v-overlay v-if="dialog" class="overlay-blur" absolute></v-overlay>

    <v-dialog v-model="dialog" max-width="700px" hide-overlay>
      <v-card class="pa-4 dialog-card">
        <v-card-title class="headline mb-3">Редактирование предмета</v-card-title>

        <v-card-text>
          <v-row dense>
            <v-col cols="4">
              <v-sheet class="icon-background rounded-lg d-flex align-center" elevation="1">
                <v-img :src="editedItem.icon" max-width="100" max-height="100"></v-img>
              </v-sheet>
            </v-col>

            <v-col cols="4" class="d-flex flex-column justify-start pl-2">
              <v-text-field
                  label="Предельный"
                  v-model.number="editedItem.float_limit"
                  dense
                  class="mb-2"
                  :rules="[v => !!v || 'Поле обязательно']"
              ></v-text-field>
              <v-text-field
                  label="Максимальная цена"
                  v-model.number="editedItem.max_price"
                  dense
                  class="mb-2"
                  :rules="[v => !!v || 'Поле обязательно']"
              ></v-text-field>
            </v-col>

            <v-col cols="4" class="d-flex flex-column justify-start pl-2">
              <v-select
                  label="Направление"
                  :items="['MIN','MAX']"
                  v-model="editedItem.extremum"
                  dense
                  class="mb-2"
                  :rules="[v => !!v || 'Поле обязательно']"
              ></v-select>
              <v-switch
                  label="Активен"
                  v-model="editedItem.is_active"
                  dense
              ></v-switch>
            </v-col>
          </v-row>

          <v-row dense class="mt-3">
            <v-col cols="12" class="mb-2">
              <v-text-field
                  label="Название"
                  v-model="editedItem.market_name"
                  dense
                  :rules="[v => !!v || 'Поле обязательно']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" class="mb-2">
              <v-text-field
                  label="Name"
                  v-model="editedItem.market_hash_name"
                  dense
                  :rules="[v => !!v || 'Поле обязательно']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" class="mb-2">
              <v-text-field
                  label="ID"
                  v-model="editedItem.id"
                  dense
                  :rules="[v => !!v || 'Поле обязательно']"
              ></v-text-field>
            </v-col>
            <v-col cols="12" class="mb-2">
              <v-text-field
                  label="Ссылка на иконку"
                  v-model="editedItem.icon"
                  dense
                  :rules="[v => !!v || 'Поле обязательно']"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="saveItem">Сохранить</v-btn>
          <v-btn text @click="dialog = false">Отмена</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-container>
</template>

<script>
import {$api} from "@/api";
import SearchBar from "@/components/SearchBar.vue";

export default {
  name: "MainView",
  components: {SearchBar},
  data() {
    return {
      skinSettings: [],
      dialog: false,
      editedItem: {},
      skins: [],
      searchQuery: '',
      showDropdown: false,
    };
  },
  async created() {
    try {
      const response = await $api.skinSearch.index();
      if (response.data?.data) {
        this.skinSettings = response.data.data
        console.log(response.data)
      }
    } catch (e) {
      this.$toast.error(e.message);
    }
  },
  methods: {
    openDialog(item) {
      this.editedItem = { ...item };
      this.dialog = true;
    },
    saveItem() {

      this.dialog = false;
    },

    async handleAddClick(query) {
      try {
        const response = await $api.skinSearch.findSkins(query)
        if (response.data?.data) {
          // Берём только нужные поля для выпадающего списка
          this.skins = response.data.data.map(item => ({
            id: item.market_hash_name, // или другой уникальный идентификатор
            market_name: item.market_name,
            icon_url: item.icon_url
          }))
          this.showDropdown = true
        } else {
          this.skins = []
          this.showDropdown = false
        }
      } catch (error) {
        console.error('Ошибка загрузки предметов:', error)
        this.skins = []
        this.showDropdown = false
      }

    },

    handleItemSelected(item) {
      console.log('Выбран предмет:', item)
      this.showDropdown = false
      this.searchQuery = ''
    },

    handleSearchFocus() {
      if (this.searchQuery.trim() && this.skins.length > 0) {
        this.showDropdown = true
      }
    },
  }
};
</script>

<style scoped>
.clickable-card {
  border-radius: 12px;
  background-color: #f5f9fc;
  transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
  box-shadow: 0 3px 8px rgba(0,0,0,0.12);
  cursor: pointer;
}

.clickable-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.18);
}

.indicators span {
  margin-right: 25px;
  font-size: 14px;
}

.indicator-limit strong { color: #1976d2; }
.indicator-max strong { color: #388e3c; }
.indicator-extremum strong { color: #f57c00; }

.overlay-blur {
  backdrop-filter: blur(8px);
  background-color: rgba(0,0,0,0.4);
  z-index: 5;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.dialog-card {
  border-radius: 16px;
  background-color: rgba(245, 249, 252, 0.95);
}

.icon-background {
  width: 110px;
  height: 110px;
  background-color: #e3f2fd;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding-left: 5px;
}

.v-col.pl-2 {
  padding-left: 8px !important;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
}

.v-text-field.dense,
.v-select.dense,
.v-switch.dense {
  margin-top: 4px;
  margin-bottom: 4px;
}

.v-card-title.mb-3 {
  margin-bottom: 12px !important;
}

</style>
