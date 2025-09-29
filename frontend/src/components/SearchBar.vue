<template>
  <div class="search-container">
    <div class="search-bar">
      <div class="search-input-wrapper">
        <input
            v-model="localQuery"
            type="text"
            placeholder="Введите название предмета..."
            class="search-input"
            @input="handleInput"
            @focus="$emit('search-focus')"
        />
        <button class="add-button" @click="handleAddClick">
          <span class="add-button-text">Добавить</span>
          <svg class="add-icon" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8 1v14M1 8h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </div>

      <!-- Выпадающий список -->
      <div v-if="showDropdown && items.length > 0" class="dropdown">
        <div
            v-for="item in items"
            :key="item.id"
            class="dropdown-item"
            @click="selectItem(item)"
        >
          <img :src="item.icon_url" :alt="item.market_name" class="item-image" />
          <span class="item-name">{{ item.market_name }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  props: {
    items: {
      type: Array,
      default: () => []
    },
    searchQuery: {
      type: String,
      default: ''
    },
    showDropdown: {
      type: Boolean,
      default: false
    }
  },
  emits: ['update:searchQuery', 'search-input', 'add-click', 'item-selected', 'search-focus'],
  data() {
    return {
      localQuery: this.searchQuery
    }
  },
  watch: {
    searchQuery(newVal) {
      this.localQuery = newVal
    }
  },
  methods: {
    handleInput() {
      this.$emit('update:searchQuery', this.localQuery)
      this.$emit('search-input', this.localQuery)
    },

    handleAddClick() {
      this.$emit('add-click', this.localQuery)
    },

    selectItem(item) {
      this.$emit('item-selected', item)
    },
    handleClickOutside(event) {
      if (!this.$el.contains(event.target)) {
        this.$emit('update:showDropdown', false) // используем правильное имя пропа
      }
    }
  },

  mounted() {
    document.addEventListener('click', this.handleClickOutside)
  },

  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside)
  },

}
</script>

<style scoped>
.search-container {
  width: 100%;
  max-width: 600px;
  margin: 0 auto 20px;
}

.search-bar {
  position: relative;
  width: 100%;
}

.search-input-wrapper {
  display: flex;
  align-items: center;
  background: #ffffff;
  border-radius: 25px;
  padding: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  border: 2px solid #e1e5e9;
  transition: all 0.3s ease;
}

.search-input-wrapper:focus-within {
  border-color: #3b82f6;
  box-shadow: 0 2px 15px rgba(59, 130, 246, 0.2);
}

.search-input {
  flex: 1;
  border: none;
  outline: none;
  padding: 12px 20px;
  font-size: 16px;
  background: transparent;
  border-radius: 25px;
}

.search-input::placeholder {
  color: #9ca3af;
}

.add-button {
  display: flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #3b82f6, #1d4ed8);
  color: white;
  border: none;
  border-radius: 20px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.add-button:hover {
  background: linear-gradient(135deg, #2563eb, #1e40af);
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.add-button:active {
  transform: translateY(0);
}

.add-button-text {
  display: inline-block;
}

.add-icon {
  display: none;
}

/* Выпадающий список */
.dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  margin-top: 8px;
  max-height: 300px;
  overflow-y: auto;
  z-index: 1000;
  border: 1px solid #e5e7eb;
}

.dropdown-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  cursor: pointer;
  transition: background-color 0.2s ease;
  border-bottom: 1px solid #f3f4f6;
}

.dropdown-item:last-child {
  border-bottom: none;
}

.dropdown-item:hover {
  background-color: #f8fafc;
}

.item-image {
  width: 32px;
  height: 32px;
  border-radius: 6px;
  object-fit: cover;
  border: 1px solid #e5e7eb;
}

.item-name {
  font-size: 14px;
  font-weight: 500;
  color: #374151;
}

/* Адаптивность */
@media (max-width: 640px) {
  .search-container {
    max-width: 100%;
    padding: 0 16px;
  }

  .search-input-wrapper {
    border-radius: 20px;
  }

  .add-button {
    padding: 10px 16px;
  }

  .add-button-text {
    display: none;
  }

  .add-icon {
    display: block;
  }

  .search-input {
    font-size: 14px;
    padding: 10px 16px;
  }
}
</style>
