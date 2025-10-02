<template>
  <div class="found-skins-page">
    <!-- Заголовок и статистика -->
    <div class="page-header">
      <h1 class="page-title">Найденные скины</h1>
      <div class="stats">
        <div class="stat-item">
          <span class="stat-value">{{ totalItems }}</span>
          <span class="stat-label">всего скинов</span>
        </div>
        <div class="stat-item">
          <span class="stat-value rare">{{ rareCount }}</span>
          <span class="stat-label">редких</span>
        </div>
      </div>
    </div>

    <!-- Фильтры и сортировка -->
    <div class="filters-section">
      <div class="filters-row">
        <!-- Фильтр по редкости -->
        <div class="filter-group">
          <label class="filter-label">Редкость</label>
          <div class="radio-group">
            <label class="radio-label">
              <input
                  type="radio"
                  v-model="filters.is_rare"
                  :value="undefined"
                  class="radio-input"
              >
              <span class="radio-custom"></span>
              <span class="radio-text">Все скины</span>
            </label>
            <label class="radio-label">
              <input
                  type="radio"
                  v-model="filters.is_rare"
                  :value="1"
                  class="radio-input"
              >
              <span class="radio-custom"></span>
              <span class="radio-text">Только редкие</span>
            </label>
          </div>
        </div>

        <!-- Фильтр по предмету -->
        <div class="filter-group">
          <label class="filter-label">Предмет</label>
          <select v-model="filters.skin_id" class="select-field">
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

        <!-- Сортировка -->
        <div class="filter-group">
          <label class="filter-label">Сортировка</label>
          <select v-model="sortBy" class="select-field">
            <option value="date">По дате</option>
            <option value="float">По float</option>
            <option value="price">По цене</option>
          </select>
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

    <!-- Сетка карточек -->
    <div class="skins-grid">
      <SkinCard
          v-for="skin in skins"
          :key="skin.id"
          :skin="skin"
          @click="openSkinDetails(skin)"
      />
    </div>

    <!-- Индикатор загрузки -->
    <div v-if="loading" class="loading-indicator">
      <div class="spinner"></div>
      <span>Загрузка скинов...</span>
    </div>

    <!-- Сообщение о конце списка -->
    <div v-if="!hasMore && skins.length > 0" class="end-of-list">
      <span>Все скины загружены</span>
    </div>

    <!-- Сообщение если нет скинов -->
    <div v-if="!loading && skins.length === 0" class="empty-state">
      <svg width="64" height="64" viewBox="0 0 64 64" fill="currentColor">
        <path d="M32 12L12 32h8v20h24V32h8L32 12z" fill="none" stroke="currentColor" stroke-width="2"/>
      </svg>
      <h3>Скины не найдены</h3>
      <p>Попробуйте изменить параметры фильтров</p>
    </div>

    <!-- Диалог деталей скина -->
    <SkinDetailsDialog
        v-if="selectedSkin"
        :skin="selectedSkin"
        :open="showDetailsDialog"
        @close="closeSkinDetails"
    />
  </div>
</template>

<script>
import SkinCard from '@/components/SkinCard.vue'
import SkinDialog from '@/components/SkinDialog.vue'
import {$api} from "@/api";

export default {
  name: 'FoundSkinsPage',
  components: {
    SkinCard,
    SkinDetailsDialog: SkinDialog
  },
  data() {
    return {
      skins: [],
      loading: false,
      hasMore: true,
      currentPage: 1,
      perPage: 20,
      totalItems: 0,
      rareCount: 0,
      selectedSkin: null,
      showDetailsDialog: false,
      scrollThrottle: false,

      filters: {
        is_rare: undefined,
        skin_id: undefined
      },

      sortBy: 'date',
      availableItems: [],
    }
  },

  watch: {
    filters: {
      handler() {
        this.resetAndLoad()
      },
      deep: true,
      immediate: false
    },

    sortBy() {
      this.resetAndLoad()
    }
  },

  mounted() {
    this.loadSkins()
    window.addEventListener('scroll', this.handleScroll)
    window.addEventListener('resize', this.handleScroll)
  },

  beforeDestroy() {
    window.removeEventListener('scroll', this.handleScroll)
    window.removeEventListener('resize', this.handleScroll)
  },

  async created() {
    try {
      const response = await $api.skinSearch.all()
      this.availableItems = response.data.data
    }
    catch (e) {
      this.$toast.error(e.message)
    }
  },

  methods: {
    async loadSkins() {
      if (this.loading) return

      this.loading = true

      try {
        const params = {
          per_page: this.perPage,
          page: this.currentPage,
          sort_by: this.sortBy,
          ...this.filters
        }

        let response = await $api.lots.index(params)

        if (this.currentPage === 1) {
          this.skins = response.data.data
        } else {
          this.skins.push(...response.data.data)
        }

        this.totalItems = response.data.meta.total ?? 110
        this.rareCount = response.data.meta.rare_count ?? 10
        this.hasMore = response.data.meta.total_pages !== response.data.meta.current_page

      } catch (error) {
        this.$toast.error(error.message)
      } finally {
        this.loading = false
        this.scrollThrottle = false
      }
    },

    handleScroll() {
      if (this.loading || this.scrollThrottle || !this.hasMore) return

      const scrollTop = window.pageYOffset || document.documentElement.scrollTop
      const windowHeight = window.innerHeight
      const documentHeight = document.documentElement.scrollHeight

      const scrollBottom = scrollTop + windowHeight
      const scrollThreshold = documentHeight - 100

      if (scrollBottom >= scrollThreshold) {
        this.scrollThrottle = true
        this.loadMore()
      }
    },

    async loadMore() {
      if (!this.hasMore || this.loading) return

      this.currentPage++
      await this.loadSkins()
    },

    resetAndLoad() {
      this.currentPage = 1
      this.skins = []
      this.hasMore = true
      this.loadSkins()
    },

    resetFilters() {
      this.filters = {
        is_rare: undefined,
        skin_id: undefined
      }
      this.sortBy = 'date'
    },

    openSkinDetails(skin) {
      this.selectedSkin = skin
      this.showDetailsDialog = true
    },

    closeSkinDetails() {
      this.showDetailsDialog = false
      this.selectedSkin = null
    },
  }
}
</script>

<style scoped>
.found-skins-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  padding-bottom: 20px;
  border-bottom: 1px solid #e1e5e9;
  /* Убрал sticky и background */
}

.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: #2d3748;
  margin: 0;
}

.stats {
  display: flex;
  gap: 30px;
}

.stat-item {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.stat-value {
  font-size: 1.5rem;
  font-weight: 700;
  color: #2d3748;
}

.stat-value.rare {
  color: #d4af37;
}

.stat-label {
  font-size: 0.8rem;
  color: #718096;
  margin-top: 4px;
}

.filters-section {
  background: #ffffff;
  border: 1px solid #e1e5e9;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 30px;
}

.filters-row {
  display: flex;
  align-items: end;
  gap: 24px;
  flex-wrap: wrap;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-width: 150px;
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
}

.reset-filters:hover {
  background: #f8f9fa;
  border-color: #cbd5e0;
}

.skins-grid {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 30px;
}

.loading-indicator {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  padding: 40px;
  color: #718096;
}

.spinner {
  width: 32px;
  height: 32px;
  border: 3px solid #e2e8f0;
  border-top: 3px solid #1976d2;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.end-of-list {
  text-align: center;
  padding: 20px;
  color: #718096;
  font-style: italic;
}

.empty-state {
  text-align: center;
  padding: 60px 20px;
  color: #a0aec0;
}

.empty-state svg {
  margin-bottom: 20px;
  color: #e2e8f0;
}

.empty-state h3 {
  margin: 0 0 8px 0;
  color: #718096;
}

.empty-state p {
  margin: 0;
  font-size: 0.9rem;
}

/* Адаптивность */
@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 16px;
  }

  .stats {
    align-self: stretch;
    justify-content: space-around;
  }

  .filters-row {
    flex-direction: column;
    align-items: stretch;
  }

  .filter-group {
    min-width: auto;
  }
}
</style>
