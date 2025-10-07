<template>
  <div v-if="open" class="dialog-overlay" @click="close">
    <div class="dialog-card" @click.stop>
      <div class="dialog-header">
        <h2 class="dialog-title">{{ skin.name }}</h2>
        <button class="close-button" @click="close">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </div>

      <div class="dialog-content">
        <div class="skin-main-info">
          <div class="skin-image-large">
            <img :src="skin.icon" :alt="skin.name" class="skin-image" />
          </div>

          <div class="skin-details">
            <div class="detail-item">
              <span class="detail-label">Float:</span>
              <span class="detail-value">{{ skin.float }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Цена:</span>
              <span class="detail-value price">{{ formatPriceRUB(skin.price) }}</span>
            </div>
            <div class="detail-item">
              <span class="detail-label">Дата находки:</span>
              <span class="detail-value">{{ formatDateTime(skin.found_at) }}</span>
            </div>
            <div class="detail-item" v-if="skin.page">
              <span class="detail-label">Страница:</span>
              <span class="detail-value">{{ skin.page }}</span>
            </div>
          </div>
        </div>

        <!-- Стикеры -->
        <div class="stickers-section">
          <h3 class="section-title">Стикеры</h3>
          <div class="stickers-grid">
            <div
                v-for="index in 5"
                :key="index"
                class="sticker-slot"
                :class="{ 'sticker-slot--empty': !getStickerBySlot(index - 1) }"
            >
              <div v-if="getStickerBySlot(index - 1)" class="sticker-item-compact">
                <img
                    :src="getStickerBySlot(index - 1).icon"
                    :alt="getStickerBySlot(index - 1).name"
                    class="sticker-image-compact"
                    :title="getStickerBySlot(index - 1).name"
                />
                <div class="sticker-info-compact">
                  <div class="sticker-price-compact">{{ formatPriceUSD(getStickerBySlot(index - 1).price) }}</div>
                  <div v-if="getStickerBySlot(index - 1).wear > 0" class="sticker-wear-compact">
                    {{ formatWear(getStickerBySlot(index - 1).wear) }}
                  </div>
                </div>
              </div>
              <div v-else class="empty-slot-compact">
                <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M10 3a7 7 0 100 14 7 7 0 000-14zM5 10a5 5 0 1110 0A5 5 0 015 10z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M7 10h6M10 7v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
              </div>
            </div>
          </div>
          <div v-if="skin.stickers_price > 0" class="stickers-total">
            Стикеры: {{ formatPriceUSD(skin.stickers_price) }}
          </div>
        </div>
      </div>

      <div class="dialog-actions">
        <button class="action-button primary" @click="openSteamLink">
          Купить в Steam
        </button>
        <button class="action-button inspect" @click="openInspectLink">
          Осмотреть в игре
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkinDialog',
  props: {
    skin: {
      type: Object,
      required: true
    },
    open: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    sortedStickers() {
      if (!this.skin.stickers) return []
      return [...this.skin.stickers].sort((a, b) => (a.slot || 0) - (b.slot || 0))
    }
  },
  methods: {
    close() {
      this.$emit('close')
    },

    formatPriceRUB(price) {
      return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        minimumFractionDigits: 0
      }).format(price)
    },

    formatPriceUSD(price) {
      return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
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

    formatWear(wear) {
      // Конвертируем в проценты и округляем
      return Math.round(wear * 100) + '%'
    },

    getStickerBySlot(slot) {
      return this.sortedStickers.find(sticker => sticker.slot === slot) || null
    },

    openSteamLink() {
      if (this.skin.steam_link) {
        window.open(this.skin.steam_link, '_blank')
      }
    },

    openInspectLink() {
      if (this.skin.inspect_link) {
        window.open(this.skin.inspect_link, '_blank')
      }
    }
  }
}
</script>

<style scoped>
.dialog-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(8px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 20px;
}

.dialog-card {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  width: 100%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
  border: 1px solid #e1e5e9;
}

.dialog-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px 20px 0;
  margin-bottom: 16px;
}

.dialog-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0;
  line-height: 1.3;
}

.close-button {
  background: none;
  border: none;
  cursor: pointer;
  color: #718096;
  padding: 6px;
  border-radius: 6px;
  transition: all 0.2s ease;
  flex-shrink: 0;
}

.close-button:hover {
  background: #f8f9fa;
  color: #4a5568;
}

.dialog-content {
  padding: 0 20px;
}

.skin-main-info {
  display: flex;
  gap: 20px;
  margin-bottom: 20px;
  align-items: stretch; /* Выравниваем по высоте */
}

.skin-image-large {
  flex-shrink: 0;
  width: 140px; /* Увеличили ширину */
  height: 105px; /* Увеличили высоту */
  border-radius: 8px;
  overflow: hidden;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  display: flex;
  align-items: center;
  justify-content: center;
}

.skin-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
  padding: 8px;
}

.skin-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between; /* Равномерно распределяем пространство */
  min-height: 105px; /* Такая же высота как у изображения */
}

.detail-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 8px 0;
  border-bottom: 1px solid #f1f3f4;
}

.detail-item:last-child {
  border-bottom: none;
}

.detail-label {
  font-size: 0.85rem;
  font-weight: 500;
  color: #4a5568;
}

.detail-value {
  font-size: 0.85rem;
  font-weight: 500;
  color: #2d3748;
}

.detail-value.price {
  color: #388e3c;
  font-weight: 600;
}

.section-title {
  font-size: 1rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0 0 12px 0;
}

.stickers-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 12px; /* Увеличили отступы */
  margin-bottom: 12px;
}

.sticker-slot {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
}

.sticker-item-compact {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 6px;
}

.sticker-image-compact {
  width: 52px; /* Увеличили размер стикеров */
  height: 52px;
  object-fit: contain;
  border-radius: 6px;
  background: #f8f9fa;
  border: 1px solid #e9ecef;
  padding: 3px;
}

.sticker-info-compact {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
}

.sticker-price-compact {
  font-size: 0.75rem;
  font-weight: 600;
  color: #388e3c;
  background: #f0f9f0;
  padding: 3px 6px;
  border-radius: 4px;
  white-space: nowrap;
}

.sticker-wear-compact {
  font-size: 0.7rem;
  font-weight: 600;
  color: #e53e3e;
  background: #fed7d7;
  padding: 2px 4px;
  border-radius: 4px;
  white-space: nowrap;
}

.empty-slot-compact {
  width: 52px; /* Увеличили размер пустых слотов */
  height: 52px;
  border-radius: 6px;
  border: 2px dashed #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #cbd5e0;
}

.stickers-total {
  font-size: 0.8rem;
  font-weight: 600;
  color: #666;
  background: #f5f5f5;
  padding: 6px 10px;
  border-radius: 6px;
  text-align: center;
}

.dialog-actions {
  display: flex;
  gap: 10px;
  padding: 20px;
  border-top: 1px solid #e1e5e9;
  margin-top: 16px;
}

.action-button {
  flex: 1;
  padding: 10px 16px;
  border: none;
  border-radius: 8px;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.action-button.primary {
  background: #1976d2;
  color: white;
}

.action-button.primary:hover {
  background: #1565c0;
}

.action-button.inspect {
  background: #f57c00;
  color: white;
}

.action-button.inspect:hover {
  background: #e65100;
}

/* Адаптивность */
@media (max-width: 768px) {
  .skin-main-info {
    flex-direction: column;
    text-align: center;
  }

  .skin-image-large {
    align-self: center;
    width: 120px;
    height: 90px;
  }

  .skin-details {
    min-height: auto;
    gap: 8px;
  }

  .stickers-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .dialog-actions {
    flex-direction: column;
  }

  .dialog-title {
    font-size: 1.1rem;
  }
}

@media (max-width: 480px) {
  .dialog-overlay {
    padding: 10px;
  }

  .dialog-card {
    max-width: 100%;
  }

  .skin-image-large {
    width: 100px;
    height: 75px;
  }

  .stickers-grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
  }

  .sticker-image-compact {
    width: 48px;
    height: 48px;
  }

  .empty-slot-compact {
    width: 48px;
    height: 48px;
  }

  .sticker-wear-compact {
    font-size: 0.65rem;
  }
}
</style>
