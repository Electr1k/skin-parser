<template>
  <div v-if="dialog" class="dialog-overlay" @click="$emit('close')">
    <div class="dialog-card" @click.stop>
      <!-- Заголовок -->
      <div class="dialog-header">
        <h2 class="dialog-title">
          {{ mode === 'create' ? 'Создание предмета' : 'Обновление предмета' }}
        </h2>
      </div>

      <!-- Содержимое -->
      <div class="dialog-content">
        <div class="form-section">
          <div class="form-row">
            <!-- Изображение предмета -->
            <div>
              <div class="image-section">
                <div class="image-wrapper">
                  <img
                      :src="editedItem.icon"
                      :alt="editedItem.name"
                      class="item-image"
                      @error="handleImageError"
                  />
                </div>
              </div>
              <div v-if="editedItem.price" class="current-price-badge">
                ${{ editedItem.price }}
              </div>
            </div>

            <!-- Основные настройки -->
            <div class="settings-section">
              <div class="input-group">
                <label class="input-label">Предельное значение float</label>
                <input
                    type="number"
                    v-model.number="editedItem.float_limit"
                    class="input-field"
                    placeholder="Введите значение..."
                    step="0.0001"
                />
                <div v-if="!editedItem.float_limit" class="error-text">Поле обязательно</div>
              </div>

              <div class="input-group">
                <label class="input-label">Максимальная цена (руб)</label>
                <input
                    type="number"
                    v-model.number="editedItem.max_price"
                    class="input-field"
                    placeholder="Введите цену..."
                />
                <div v-if="!editedItem.max_price" class="error-text">Поле обязательно</div>
              </div>
            </div>

            <!-- Дополнительные настройки -->
            <div class="settings-section">
              <div class="input-group">
                <label class="input-label">Направление поиска float</label>
                <select v-model="editedItem.extremum" class="input-field select-field">
                  <option value="MIN">MIN</option>
                  <option value="MAX">MAX</option>
                </select>
                <div v-if="!editedItem.extremum" class="error-text">Поле обязательно</div>
              </div>

              <div class="switch-group mt-6">
                <label class="switch">
                  <input type="checkbox" v-model="editedItem.is_active" class="switch-input">
                  <span class="switch-slider"></span>
                </label>
                <span class="switch-label">Активен</span>
              </div>
            </div>
          </div>

          <!-- Детальная информация -->
          <div class="detail-section">
            <div class="input-group full-width">
              <label class="input-label">Название предмета</label>
              <input
                  type="text"
                  v-model="editedItem.name"
                  class="input-field"
                  placeholder="Введите название предмета..."
              />
              <div v-if="!editedItem.name" class="error-text">Поле обязательно</div>
            </div>

            <div class="input-group full-width">
              <label class="input-label">Ссылка на иконку</label>
              <input
                  type="text"
                  v-model="editedItem.icon"
                  class="input-field"
                  placeholder="Введите URL иконки..."
              />
              <div v-if="!editedItem.icon" class="error-text">Поле обязательно</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Действия -->
      <div class="dialog-actions">
        <button class="cancel-button" @click="$emit('close')">Отмена</button>
        <button
            :class="['submit-button', mode === 'create' ? 'create' : 'update']"
            @click="submit"
            :disabled="!isFormValid"
        >
          {{ mode === 'create' ? 'Сохранить' : 'Обновить' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ItemDialog',
  props: {
    value: {type: Boolean, default: false},
    item: {type: Object, default: () => ({})},
    mode: {type: String, default: 'update'}
  },
  data() {
    return {
      dialog: this.value,
      editedItem: {...this.item}
    }
  },
  computed: {
    isFormValid() {
      const requiredFields = [
        'float_limit',
        'max_price',
        'extremum',
        'name',
        'icon'
      ];

      return requiredFields.every(field => {
        const value = this.editedItem[field];
        return value !== undefined && value !== null && value !== '';
      });
    }
  },
  watch: {
    value(newVal) {
      this.dialog = newVal;
      if (newVal) this.editedItem = {...this.item};
    },
    dialog(newVal) {
      this.$emit('input', newVal)
    },
    item(newVal) {
      this.editedItem = {...newVal}
    },
    mode() {
      if (this.dialog) this.editedItem = {...this.item};
    }
  },
  methods: {
    submit() {
      if (!this.isFormValid) return;

      this.$emit(this.mode === 'create' ? 'create' : 'update', this.editedItem)
      this.dialog = false
    },
    handleImageError(event) {
      event.target.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIxMDAiIGhlaWdodD0iMTAwIiBmaWxsPSIjRjhGOUZBIi8+CjxwYXRoIGQ9Ik01MCAzM1Y2N001MCA2N0w2MCA1N001MCA2N0w0MCA1NyIgc3Ryb2tlPSIjQ0RDRkRFIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZS1saW5lY2FwPSJyb3VuZCIvPgo8L3N2Zz4K';
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
  max-width: 700px;
  max-height: 90vh;
  overflow-y: auto;
}

.dialog-header {
  padding: 24px 24px 0;
  border-bottom: 1px solid #e1e5e9;
}

.dialog-title {
  font-size: 1.4rem;
  font-weight: 600;
  color: #2d3748;
  margin: 0 0 20px 0;
}

.dialog-content {
  padding: 24px;
}

.form-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-row {
  display: grid;
  grid-template-columns: 120px 1fr 1fr;
  gap: 20px;
  align-items: start;
}

.image-section {
  display: flex;
  justify-content: center;
  position: relative;
}

.image-wrapper {
  width: 100px;
  height: 100px;
  border-radius: 8px;
  border: 1px solid #e1e5e9;
  background: #f8f9fa;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.item-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.current-price-badge {
  color: green;
  font-size: 16px;
  font-weight: 800;
  text-align: center;
  padding-top: 12px;
}

.settings-section {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.detail-section {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.input-group.full-width {
  grid-column: 1 / -1;
}

.input-label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #4a5568;
}

.input-field {
  padding: 10px 12px;
  border: 1px solid #e1e5e9;
  border-radius: 8px;
  font-size: 0.9rem;
  transition: all 0.2s ease;
  background: #ffffff;
}

.input-field:focus {
  outline: none;
  border-color: #1976d2;
  box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.1);
}

.input-field:disabled {
  background: #f8f9fa;
  color: #a0aec0;
  cursor: not-allowed;
}

.select-field {
  appearance: none;
  background-image: url("data:image/svg+xml;charset=US-ASCII,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'><path fill='%23666' d='M2 0L0 2h4zm0 5L0 3h4z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 12px;
  padding-right: 36px;
}

.error-text {
  font-size: 0.8rem;
  color: #e53e3e;
}

.switch-group {
  display: flex;
  align-items: center;
  gap: 10px;
  height: 42px; /* Высота соответствует полю ввода */
  margin-top: 0; /* Убираем отступ */
}

.switch {
  position: relative;
  display: inline-block;
  width: 44px;
  height: 24px;
}

.switch-input {
  opacity: 0;
  width: 0;
  height: 0;
}

.switch-slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #e2e8f0;
  transition: .4s;
  border-radius: 24px;
}

.switch-slider:before {
  position: absolute;
  content: "";
  height: 18px;
  width: 18px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  transition: .4s;
  border-radius: 50%;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.switch-input:checked + .switch-slider {
  background-color: #10b981;
}

.switch-input:checked + .switch-slider:before {
  transform: translateX(20px);
}

.switch-label {
  font-size: 0.9rem;
  color: #4a5568;
  font-weight: 500;
}

.dialog-actions {
  display: flex;
  justify-content: flex-end;
  gap: 12px;
  padding: 20px 24px 24px;
  border-top: 1px solid #e1e5e9;
}

.cancel-button {
  padding: 10px 20px;
  border: 1px solid #e1e5e9;
  border-radius: 8px;
  background: #ffffff;
  color: #4a5568;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.cancel-button:hover {
  background: #f8f9fa;
  border-color: #cbd5e0;
}

.submit-button {
  padding: 10px 24px;
  border: none;
  border-radius: 8px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.submit-button.create {
  background: #1976d2;
  color: white;
}

.submit-button.update {
  background: #10b981;
  color: white;
}

.submit-button:hover:not(:disabled) {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.submit-button:disabled {
  background: #a0aec0;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

/* Адаптивность */
@media (max-width: 768px) {
  .form-row {
    grid-template-columns: 1fr;
    gap: 16px;
  }

  .image-section {
    justify-content: flex-start;
  }

  .dialog-actions {
    flex-direction: column-reverse;
  }

  .cancel-button,
  .submit-button {
    width: 100%;
  }
}
</style>
