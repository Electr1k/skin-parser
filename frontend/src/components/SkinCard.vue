<template>
  <div
      class="skin-card"
      :class="{ 'skin-card--rare': skin.is_rare }"
      @click="$emit('click', skin)"
  >
    <!-- Изображение скина -->
    <div class="skin-image-section">
      <div class="skin-image-wrapper">
        <img
            :src="skin.icon_url"
            :alt="skin.market_name"
            class="skin-image"
        />
        <div v-if="skin.is_rare" class="rare-indicator">
          <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8 1l1.5 4.5L14 6l-3.5 3 1 4.5L8 11.5 4.5 13.5l1-4.5L2 6l4.5-.5L8 1z" fill="currentColor"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- Основная информация -->
    <div class="skin-info" ref="infoSection">
      <h3 class="skin-name">{{ skin.market_name }}</h3>

      <div class="skin-meta">
        <div class="meta-item">
          <span class="meta-label">Float</span>
          <span class="meta-value float">{{ skin.float_value }}</span>
        </div>
        <div class="meta-item">
          <span class="meta-label">Цена</span>
          <span class="meta-value price">{{ formatPrice(skin.price) }}</span>
        </div>
        <div class="meta-item">
          <span class="meta-label">Дата</span>
          <span class="meta-value date">{{ formatDateTime(skin.found_date) }}</span>
        </div>
      </div>
    </div>

    <!-- Стикеры -->
    <div class="stickers-section">
      <div class="stickers-list">
        <div
            v-for="index in 4"
            :key="index"
            class="sticker-slot"
            :class="{ 'sticker-slot--empty': !getSticker(index - 1) }"
        >
          <div v-if="getSticker(index - 1)" class="sticker-item">
            <div class="sticker-image-wrapper">
              <img
                  :src="getSticker(index - 1).icon_url"
                  :alt="getSticker(index - 1).name"
                  class="sticker-image"
              />
            </div>
            <div class="sticker-price">{{ formatPrice(getSticker(index - 1).price) }}</div>
          </div>
          <div v-else class="empty-slot">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
              <path d="M10 3a7 7 0 100 14 7 7 0 000-14zM5 10a5 5 0 1110 0A5 5 0 015 10z" fill="none" stroke="currentColor" stroke-width="1.5"/>
              <path d="M7 10h6M10 7v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkinCard',
  props: {
    skin: {
      type: Object,
      required: true
    }
  },
  methods: {
    formatPrice(price) {
      return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        minimumFractionDigits: 0
      }).format(price)
    },

    formatDateTime(dateString) {
      const date = new Date(dateString)
      return date.toLocaleDateString('ru-RU', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      })
    },

    getSticker(index) {
      return this.skin.stickers && this.skin.stickers[index] ? this.skin.stickers[index] : null
    }
  }
}
</script>

<style scoped>
.skin-card {
  background: #ffffff;
  border: 1px solid #e1e5e9;
  border-radius: 12px;
  padding: 20px;
  transition: all 0.3s ease;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 20px;
  height: 140px;
  position: relative;
}

.skin-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  border-color: #cbd5e0;
}

.skin-card--rare {
  border-color: #d4af37;
  background: linear-gradient(135deg, #fffdf6 0%, #fff9e6 100%);
}

/* Секция изображения */
.skin-image-section {
  flex-shrink: 0;
}

.skin-image-wrapper {
  position: relative;
  width: 100px;
  height: 75px;
  border-radius: 8px;
  overflow: hidden;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  display: flex;
  align-items: center;
  justify-content: center;
}

.skin-card--rare .skin-image-wrapper {
  border-color: #d4af37;
}

.skin-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 4px;
}

.rare-indicator {
  position: absolute;
  top: 6px;
  right: 6px;
  width: 20px;
  height: 20px;
  background: #d4af37;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

/* Основная информация */
.skin-info {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  gap: 12px;
  max-width: calc(100% - 400px); /* Ограничиваем ширину чтобы осталось место для стикеров */
}

.skin-name {
  font-size: 0.95rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0;
  line-height: 1.3;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.skin-meta {
  display: flex;
  gap: 24px;
}

.meta-item {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.meta-label {
  font-size: 0.75rem;
  color: #718096;
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.meta-value {
  font-size: 0.85rem;
  font-weight: 600;
  font-family: 'Courier New', monospace;
  white-space: nowrap;
}

.meta-value.float {
  color: #1976d2;
  min-width: 140px;
}

.meta-value.price {
  color: #388e3c;
}

.meta-value.date {
  color: #f57c00;
  font-family: inherit;
  min-width: 140px;
}

/* Секция стикеров */
.stickers-section {
  position: absolute;
  left: calc(50% + 120px); /* Сдвигаем от центра вправо */
  top: 50%;
  transform: translateY(-50%);
  z-index: 2;
}

.stickers-list {
  display: flex;
  gap: 16px;
  align-items: flex-start;
}

.sticker-slot {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  height: 68px;
}

.sticker-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
  height: 100%;
  justify-content: flex-start;
}

.sticker-image-wrapper {
  width: 48px;
  height: 48px;
  border-radius: 6px;
  overflow: hidden;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 4px;
  transition: transform 0.2s ease;
  flex-shrink: 0;
}

.sticker-item:hover .sticker-image-wrapper {
  transform: scale(1.05);
}

.sticker-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.sticker-price {
  font-size: 0.7rem;
  font-weight: 600;
  color: #388e3c;
  background: #f0f9f0;
  padding: 2px 6px;
  border-radius: 8px;
  white-space: nowrap;
  flex-shrink: 0;
}

/* Пустые слоты */
.empty-slot {
  width: 48px;
  height: 48px;
  border-radius: 6px;
  border: 2px dashed #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #cbd5e0;
  transition: all 0.2s ease;
  pointer-events: none;
  flex-shrink: 0;
}

/* Адаптивность */
@media (max-width: 1024px) {
  .skin-card {
    gap: 16px;
    padding: 16px;
    height: 130px;
  }

  .skin-info {
    max-width: calc(100% - 320px);
  }

  .stickers-section {
    left: calc(50% + 80px);
  }

  .stickers-list {
    gap: 12px;
  }

  .sticker-image-wrapper,
  .empty-slot {
    width: 40px;
    height: 40px;
  }

  .sticker-slot {
    height: 60px;
  }

  .meta-value.float,
  .meta-value.date {
    min-width: 120px;
  }
}

@media (max-width: 768px) {
  .skin-card {
    height: auto;
    flex-wrap: wrap;
    gap: 12px;
    padding: 16px;
  }

  .skin-info {
    max-width: none;
    order: 1;
    flex: 1 1 100%;
  }

  .skin-image-wrapper {
    width: 80px;
    height: 60px;
  }

  .skin-meta {
    gap: 16px;
  }

  .meta-value.float,
  .meta-value.date {
    min-width: 100px;
  }

  .stickers-section {
    position: static;
    transform: none;
    order: 2;
    width: 100%;
    margin-top: 12px;
    left: auto;
  }

  .stickers-list {
    justify-content: flex-start;
    flex-wrap: wrap;
    gap: 12px;
  }

  .sticker-slot {
    height: auto;
  }
}

@media (max-width: 480px) {
  .skin-card {
    padding: 12px;
  }

  .skin-meta {
    flex-direction: column;
    gap: 8px;
  }

  .meta-item {
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
  }

  .meta-value.float,
  .meta-value.date {
    min-width: 80px;
    font-size: 0.8rem;
  }

  .stickers-list {
    gap: 8px;
  }

  .sticker-image-wrapper,
  .empty-slot {
    width: 36px;
    height: 36px;
  }

  .sticker-price {
    font-size: 0.65rem;
  }
}
</style>
