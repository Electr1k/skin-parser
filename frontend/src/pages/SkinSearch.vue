<template>
  <v-container>
    <SearchBar
        v-model="searchQuery"
        :showDropdown.sync="showDropdown"
        :items="skins"
        @add-click="handleAddClick"
        @item-selected="handleItemSelected"
        @search-focus="handleSearchFocus"
        @search-input="handleSearchInput"
    />

    <v-row>
      <v-col
          v-for="(item, index) in skinSettings"
          :key="index"
          cols="12"
      >
        <ItemCard :item="item" @click="openDialog(item)" />
      </v-col>
    </v-row>

    <ItemDialog
        v-model="dialog"
        :item="editedItem"
        :mode="dialogMode"
        @update="updateItem"
        @create="createItem"
        @close="dialog = false"
    />

    <v-overlay v-if="dialog" class="overlay-blur" absolute></v-overlay>
  </v-container>
</template>

<script>
import {$api} from "@/api";
import SearchBar from "@/components/SearchBar.vue";
import ItemCard from "@/components/SkinSearchCard.vue";
import ItemDialog from "@/components/SkinSearchDialog.vue";

export default {
  name: "SkinSearch",
  components: { SearchBar, ItemCard, ItemDialog },
  data() {
    return {
      skinSettings: [],
      dialog: false,
      editedItem: {},
      dialogMode: 'update',
      skins: [],
      searchQuery: '',
      showDropdown: false,
      searchTimeout: null
    };
  },
  async created() {
    await this.getSkinSettings()
  },
  methods: {
    async getSkinSettings(){
      try {
        const response = await $api.skinSearch.index();
        if (response.data?.data) {
          this.skinSettings = response.data.data;
        }
      } catch (e) {
        this.$toast.error(e.message);
      }
    },
    openDialog(item) {
      this.editedItem = {
        name: item.name,
        ru_name: item.ru_name,
        max_price: item.max_price,
        price: item.price,
        is_active: item.is_active,
        float_limit: item.float_limit,
        extremum: item.extremum,
        min_stickers_price: item.min_stickers_price,
        min_keychains_price: item.min_keychains_price,
        icon: item.icon,
      };
      this.dialogMode = 'update';
      this.dialog = true;
    },
    async updateItem(updatedItem) {
      try {
        await $api.skinSearch.update(updatedItem.name, updatedItem)
      }
      catch (exception){
        this.$toast.error(exception.message);
      }
      await this.getSkinSettings()
    },
    async createItem(newItem) {
      try {
        await $api.skinSearch.store(newItem)
      }
      catch (exception){
        this.$toast.error(exception.message);
      }
      await this.getSkinSettings()
    },

    async handleSearchInput(query) {
      if (this.searchTimeout) {
        clearTimeout(this.searchTimeout);
      }

      this.searchTimeout = setTimeout(async () => {
        if (query.trim()) {
          await this.performSearch(query);
        } else {
          this.skins = [];
          this.showDropdown = false;
        }
      }, 300);
    },

    async performSearch(query) {
      try {
        const response = await $api.skinSearch.findSkins(query);
        this.skins = response.data.data;
        this.showDropdown = this.skins.length > 0;
      } catch (error) {
        this.$toast.error(error.message);
        this.skins = [];
        this.showDropdown = false;
      }
    },

    handleAddClick(query) {
      if (query.trim()) {
        this.performSearch(query);
      }
    },

    handleItemSelected(item) {
      this.editedItem = {
        name: item.name,
        icon: item.icon,
        float_limit: null,
        max_price: null,
        extremum: null,
        is_active: true,
        price: item.price
      };
      this.dialogMode = 'create';
      this.dialog = true;
      this.showDropdown = false;
      this.searchQuery = '';
    },

    handleSearchFocus() {
      if (this.searchQuery.trim() && this.skins.length > 0) {
        this.showDropdown = true;
      }
    },
  }
};
</script>

<style scoped>
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
</style>
