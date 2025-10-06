<template>
  <div class="filters-section">
    <div class="filters-row">
      <!-- Фильтр по редкости -->
      <div class="filter-group rarity-group">
        <label class="filter-label">Редкость</label>
        <div class="radio-group">
          <label class="radio-label">
            <input
                type="radio"
                v-model="localFilters.rarity"
                value="all"
                class="radio-input"
            >
            <span class="radio-custom"></span>
            <span class="radio-text">Все скины</span>
          </label>
          <label class="radio-label">
            <input
                type="radio"
                v-model="localFilters.rarity"
                value="rare_float"
                class="radio-input"
            >
            <span class="radio-custom"></span>
            <span class="radio-text">Редкий float</span>
          </label>
          <label class="radio-label">
            <input
                type="radio"
                v-model="localFilters.rarity"
                value="with_stickers"
                class="radio-input"
            >
            <span class="radio-custom"></span>
            <span class="radio-text">Со стикерами</span>
          </label>
          <label class="radio-label">
            <input
                type="radio"
                v-model="localFilters.rarity"
                value="rare"
                class="radio-input"
            >
            <span class="radio-custom"></span>
            <span class="radio-text">Редкие</span>
          </label>
        </div>
      </div>

      <!-- Фильтр по предмету и сортировка в одной колонке -->
      <div class="filter-column">
        <div class="filter-group">
          <label class="filter-label">Предмет</label>
          <select v-model="localFilters.skin_id" class="select-field">
            <option :value="undefined">Все предметы</option>
            <option
                v-for="item in availableItems"
                :key="item.id"
                :value="item.id"
            >
              {{ item.market_name }}
            </option>
          </select>
        </div>

        <div class="filter-group">
          <label class="filter-label">Сортировка</label>
          <select v-model="localSortBy" class="select-field">
            <option value="date">По дате</option>
            <option value="float">По float</option>
            <option value="price">По цене</option>
          </select>
        </div>
      </div>

      <!-- Кнопка сброса -->
      <button class="reset-filters" @click="resetFilters">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
          <path d="M12.5 3.5L3.5 12.5M3.5 3.5L12.5 12.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Сбросить
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SkinFilters',
  props: {
    filters: {
      type: Object,
      required: true
    },
    sortBy: {
      type: String,
      default: 'date'
    },
    availableItems: {
      type: Array,
      default: () => []
    }
  },
  data() {
    return {
      localFilters: {
        rarity: 'all',
        skin_id: undefined
      },
      localSortBy: this.sortBy
    }
  },
  watch: {
    localFilters: {
      handler() {
        this.emitFilters()
      },
      deep: true
    },
    localSortBy(newSortBy) {
      this.$emit('update:sortBy', newSortBy)
    },
    filters: {
      handler() {
        this.updateLocalFilters()
      },
      deep: true
    },
    sortBy(newSortBy) {
      this.localSortBy = newSortBy
    }
  },
  mounted() {
    this.updateLocalFilters()
  },
  methods: {
    updateLocalFilters() {
      // Конвертируем API фильтры в локальные
      if (this.filters.is_rare_float) {
        this.localFilters.rarity = 'rare_float'
      } else if (this.filters.has_sticker) {
        this.localFilters.rarity = 'with_stickers'
      } else if (this.filters.is_rare) {
        this.localFilters.rarity = 'rare'
      } else {
        this.localFilters.rarity = 'all'
      }
      this.localFilters.skin_id = this.filters.skin_id
    },
    emitFilters() {
      // Конвертируем локальные фильтры в API фильтры
      const apiFilters = {
        skin_id: this.localFilters.skin_id,
        is_rare_float: undefined,
        has_sticker: undefined,
        is_rare: undefined
      }

      switch (this.localFilters.rarity) {
        case 'rare_float':
          apiFilters.is_rare_float = 1
          break
        case 'with_stickers':
          apiFilters.has_sticker = 1
          break
        case 'rare':
          apiFilters.is_rare = 1
          break
      }

      this.$emit('update:filters', apiFilters)
    },
    resetFilters() {
      this.localFilters = {
        rarity: 'all',
        skin_id: undefined
      }
      this.localSortBy = 'date'
      this.$emit('reset')
    }
  }
}
</script>

<style scoped>
.filters-section {
  background: #ffffff;
  border: 1px solid #e1e5e9;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 30px;
}

.filters-row {
  display: flex;
  align-items: start;
  gap: 24px;
  flex-wrap: wrap;
}

.rarity-group {
  min-width: 180px;
}

.filter-column {
  display: flex;
  flex-direction: column;
  gap: 16px;
  min-width: 150px;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.filter-label {
  font-size: 0.9rem;
  font-weight: 600;
  color: #4a5568;
}

.radio-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.radio-label {
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  color: #4a5568;
}

.radio-input {
  display: none;
}

.radio-custom {
  width: 16px;
  height: 16px;
  border: 2px solid #cbd5e0;
  border-radius: 50%;
  position: relative;
  transition: all 0.2s ease;
}

.radio-input:checked + .radio-custom {
  border-color: #1976d2;
  background: #1976d2;
}

.radio-input:checked + .radio-custom::after {
  content: '';
  width: 6px;
  height: 6px;
  background: white;
  border-radius: 50%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.select-field {
  padding: 10px 12px;
  border: 1px solid #e1e5e9;
  border-radius: 8px;
  font-size: 0.9rem;
  background: #ffffff;
  cursor: pointer;
  transition: all 0.2s ease;
}

.select-field:focus {
  outline: none;
  border-color: #1976d2;
  box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.reset-filters {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 10px 16px;
  border: 1px solid #e1e5e9;
  border-radius: 8px;
  background: #ffffff;
  color: #718096;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.2s ease;
  align-self: flex-end;
  margin-bottom: 8px;
}

.reset-filters:hover {
  background: #f8f9fa;
  border-color: #cbd5e0;
}

/* Адаптивность */
@media (max-width: 768px) {
  .filters-row {
    flex-direction: column;
    align-items: stretch;
    gap: 16px;
  }

  .filter-column {
    min-width: auto;
  }

  .rarity-group {
    min-width: auto;
  }

  .reset-filters {
    align-self: stretch;
    margin-bottom: 0;
  }
}
</style>
