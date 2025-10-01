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
import ItemCard from "@/components/SkinSearchItem.vue";
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
      this.editedItem = { ...item };
      this.dialogMode = 'update';
      this.dialog = true;
    },
    async updateItem(updatedItem) {
      try {
        await $api.skinSearch.update(updatedItem.id, updatedItem)
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
    async handleAddClick(query) {
      try {
        const response = await $api.skinSearch.findSkins(query);
          this.skins = response.data.data
          this.showDropdown = true;
      } catch (error) {
        this.$toast.error(error.message);
        this.skins = [];
        this.showDropdown = false;
      }
    },

    handleItemSelected(item) {
      this.editedItem = {
        market_name: item.market_name,
        market_hash_name: item.market_hash_name,
        icon: item.icon_url,
        float_limit: null,
        max_price: null,
        extremum: null,
        is_active: true
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
