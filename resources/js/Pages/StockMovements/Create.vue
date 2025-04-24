<template>
  <AppLayout title="Record Stock Movement">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Record Stock Movement</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <form @submit.prevent="submit" class="p-6">
            <div class="max-w-xl space-y-6">
              <div>
                <label for="product_id" class="form-label">Product</label>
                <select
                  id="product_id"
                  v-model="form.product_id"
                  class="select-field"
                  :class="{ 'border-red-500': form.errors.product_id }"
                >
                  <option value="">Select Product</option>
                  <option v-for="product in products" :key="product.id" :value="product.id">
                    {{ product.name }} (Current Stock: {{ product.quantity }})
                  </option>
                </select>
                <div v-if="form.errors.product_id" class="text-red-500 text-sm mt-1">
                  {{ form.errors.product_id }}
                </div>
              </div>

              <div>
                <label for="type" class="form-label">Movement Type</label>
                <select
                  id="type"
                  v-model="form.type"
                  class="select-field"
                  :class="{ 'border-red-500': form.errors.type }"
                >
                  <option value="">Select Type</option>
                  <option v-for="(label, value) in types" :key="value" :value="value">
                    {{ label }}
                  </option>
                </select>
                <div v-if="form.errors.type" class="text-red-500 text-sm mt-1">
                  {{ form.errors.type }}
                </div>
              </div>

              <div>
                <label for="quantity" class="form-label">Quantity</label>
                <input
                  id="quantity"
                  v-model="form.quantity"
                  type="number"
                  min="1"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.quantity }"
                />
                <div v-if="form.errors.quantity" class="text-red-500 text-sm mt-1">
                  {{ form.errors.quantity }}
                </div>
              </div>

              <div>
                <label for="notes" class="form-label">Notes</label>
                <textarea
                  id="notes"
                  v-model="form.notes"
                  rows="3"
                  class="input-field"
                  :class="{ 'border-red-500': form.errors.notes }"
                  placeholder="Add any additional notes here..."
                ></textarea>
                <div v-if="form.errors.notes" class="text-red-500 text-sm mt-1">
                  {{ form.errors.notes }}
                </div>
              </div>

              <div class="flex justify-end space-x-4">
                <Link :href="route('stock-movements.index')" class="btn-secondary">Cancel</Link>
                <button type="submit" class="btn-primary" :disabled="form.processing">
                  {{ form.processing ? 'Recording...' : 'Record Movement' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  products: Array,
  types: Object,
})

const form = useForm({
  product_id: '',
  type: '',
  quantity: '',
  notes: '',
})

const submit = () => {
  form.post(route('stock-movements.store'))
}
</script>

<style scoped>
.form-label {
  @apply block text-sm font-medium text-gray-700;
}

.input-field {
  @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
}

.select-field {
  @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
}

.btn-primary {
  @apply inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150;
}

.btn-secondary {
  @apply inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:border-indigo-300 focus:ring ring-indigo-200 disabled:opacity-25 transition ease-in-out duration-150;
}
</style>
