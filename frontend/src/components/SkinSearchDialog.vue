<template>
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
        <v-btn color="primary" @click="$emit('save', editedItem)">Сохранить</v-btn>
        <v-btn text @click="$emit('close')">Отмена</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: 'ItemDialog',
  props: {
    value: { // двусторонняя привязка видимости
      type: Boolean,
      default: false
    },
    item: {
      type: Object,
      default: () => ({})
    }
  },
  data() {
    return {
      dialog: this.value,
      editedItem: { ...this.item }
    }
  },
  watch: {
    value(newVal) {
      this.dialog = newVal;
      if (newVal) this.editedItem = { ...this.item };
    },
    dialog(newVal) {
      this.$emit('input', newVal)
    },
    item(newVal) {
      this.editedItem = { ...newVal }
    }
  }
}
</script>

<style scoped>
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
</style>
