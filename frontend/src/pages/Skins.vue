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
    <SkinFilters
        :filters="filters"
        :sort-by="sortBy"
        :available-items="availableItems"
        @update:filters="updateFilters"
        @update:sortBy="updateSortBy"
        @reset="resetFilters"
    />

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
import SkinFilters from '@/components/SkinFilters.vue'
import {$api} from "@/api";

export default {
  name: 'FoundSkinsPage',
  components: {
    SkinCard,
    SkinFilters,
    SkinDetailsDialog: SkinDialog
  },
  data() {
    return {
      skins: [],
      loading: false,
      hasMore: true,
      currentPage: 1,
      perPage: 100,
      totalItems: 0,
      rareCount: 0,
      selectedSkin: null,
      showDetailsDialog: false,
      scrollThrottle: false,

      filters: {
        is_rare_float: undefined,
        has_sticker: undefined,
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
    } catch (e) {
      this.$toast.error(e.message)
    }
  },

  methods: {
    updateFilters(newFilters) {
      this.filters = newFilters
    },

    updateSortBy(newSortBy) {
      this.sortBy = newSortBy
    },

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

        // Очищаем параметры
        Object.keys(params).forEach(key => {
          if (params[key] === undefined || params[key] === '') {
            delete params[key]
          }
        })

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
        is_rare_float: undefined,
        has_sticker: undefined,
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
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
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
}
</style>
