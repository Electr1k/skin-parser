<template>
  <v-card
      class="d-flex align-center pa-4 shadow-card clickable-card"
      height="120px"
      @click="$emit('click', item)"
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
</template>

<script>
export default {
  name: 'ItemCard',
  props: {
    item: {
      type: Object,
      required: true
    }
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
</style>
