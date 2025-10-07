<template>
  <div
      class="search-config-card"
      @click="$emit('click', item)"
  >
    <div class="card-content">
      <!-- Изображение предмета -->
      <div class="item-image-wrapper">
        <img
            :src="item.icon"
            :alt="item.market_name"
            class="item-image"
        />
      </div>

      <!-- Информация о предмете -->
      <div class="item-info">
        <div class="item-name">{{ item.market_name }}</div>

        <div class="indicators">
          <div class="indicator">
            <span class="indicator-label">Предельный:</span>
            <strong class="indicator-value limit">{{ item.float_limit }}</strong>
          </div>

          <div class="indicator">
            <span class="indicator-label">Максимальная цена:</span>
            <strong class="indicator-value max-price">{{ item.max_price }} ₽</strong> <!-- Рубли -->
          </div>

          <div class="indicator">
            <span class="indicator-label">Направление:</span>
            <strong class="indicator-value extremum">{{ item.extremum }}</strong>
          </div>

          <div class="indicator" v-if="item.price">
            <span class="indicator-label">Текущая цена:</span>
            <strong class="indicator-value current-price">${{ item.price }}</strong>
          </div>
        </div>
      </div>

      <!-- Статус активности -->
      <div class="status-indicator">
        <div class="status-icon" :class="item.is_active ? 'active' : 'inactive'">
          <svg
              v-if="item.is_active"
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="currentColor"
          >
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" fill="currentColor"/>
          </svg>
          <svg
              v-else
              width="20"
              height="20"
              viewBox="0 0 20 20"
              fill="currentColor"
          >
            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" fill="currentColor"/>
          </svg>
        </div>
        <span class="status-text">{{ item.is_active ? 'Активно' : 'Неактивно' }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkinSearchCard',
  props: {
    item: {
      type: Object,
      required: true
    }
  }
};
</script>

<style scoped>
.search-config-card {
  background: #ffffff;
  border: 1px solid #e1e5e9;
  border-radius: 12px;
  padding: 20px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.search-config-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  border-color: #cbd5e0;
}

.card-content {
  display: flex;
  align-items: center;
  gap: 16px;
  height: 100%;
}

.item-image-wrapper {
  flex-shrink: 0;
  width: 80px;
  height: 80px;
  border-radius: 8px;
  overflow: hidden;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  position: relative;
}

.item-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.item-info {
  flex: 1;
  min-width: 0;
}

.item-name {
  font-size: 1.1rem;
  font-weight: 600;
  color: #2d3748;
  margin-bottom: 12px;
  line-height: 1.3;
}

.indicators {
  display: flex;
  gap: 24px;
  flex-wrap: wrap;
}

.indicator {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.indicator-label {
  font-size: 0.8rem;
  color: #718096;
  font-weight: 500;
}

.indicator-value {
  font-size: 0.95rem;
  font-weight: 600;
}

.indicator-value.limit {
  color: #1976d2;
}

.indicator-value.max-price {
  color: #388e3c;
}

.indicator-value.extremum {
  color: #f57c00;
}

.indicator-value.current-price {
  color: #10b981;
}

.status-indicator {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  flex-shrink: 0;
  padding-left: 16px;
}

.status-icon {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.status-icon.active {
  background: #f0f9ff;
  color: #10b981;
}

.status-icon.inactive {
  background: #fef2f2;
  color: #ef4444;
}

.status-text {
  font-size: 0.8rem;
  font-weight: 500;
  color: #6b7280;
}

/* Адаптивность */
@media (max-width: 768px) {
  .card-content {
    flex-direction: column;
    text-align: center;
  }

  .indicators {
    justify-content: center;
    gap: 16px;
  }

  .status-indicator {
    flex-direction: row;
    padding-left: 0;
    gap: 8px;
  }

  .item-image-wrapper {
    width: 60px;
    height: 60px;
  }
}
</style>
