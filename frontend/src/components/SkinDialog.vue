<template>
  <div v-if="open" class="dialog-overlay" @click="close">
    <div class="dialog-card" @click.stop>
      <div class="dialog-header">
        <h2 class="dialog-title">Детали скина</h2>
        <button class="close-button" @click="close">
          <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor">
            <path d="M15 5L5 15M5 5l10 10" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </button>
      </div>

      <div class="dialog-content">
        <p>Здесь будут детали скина {{ skin.market_name }}</p>
        <!-- Детали диалога можно оформить позже -->
      </div>

      <div class="dialog-actions">
        <button class="action-button primary">Купить</button>
        <button class="action-button secondary">Скрыть</button>
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
  methods: {
    close() {
      this.$emit('close')
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
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 20px;
}

.dialog-card {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  width: 100%;
  max-width: 500px;
  max-height: 90vh;
  overflow-y: auto;
}

.dialog-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 24px 24px 0;
  margin-bottom: 20px;
}

.dialog-title {
  font-size: 1.4rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0;
}

.close-button {
  background: none;
  border: none;
  cursor: pointer;
  color: #718096;
  padding: 8px;
  border-radius: 6px;
  transition: all 0.2s ease;
}

.close-button:hover {
  background: #f8f9fa;
  color: #4a5568;
}

.dialog-content {
  padding: 0 24px;
}

.dialog-actions {
  display: flex;
  gap: 12px;
  padding: 24px;
  border-top: 1px solid #e1e5e9;
}

.action-button {
  flex: 1;
  padding: 12px 20px;
  border: none;
  border-radius: 8px;
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

.action-button.secondary {
  background: #f8f9fa;
  color: #4a5568;
  border: 1px solid #e1e5e9;
}

.action-button.secondary:hover {
  background: #e9ecef;
}
</style>
