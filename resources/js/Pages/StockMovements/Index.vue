<template>
  <AppLayout title="Stock Movements">
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Stock Movements</h2>
        <Link v-if="can.create" :href="route('stock-movements.create')" class="btn-primary">
          Record Stock Movement
        </Link>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
          <div class="flex flex-wrap gap-4">
            <div class="w-48">
              <select v-model="filters.product_id" class="select-field" @change="filter">
                <option value="">All Products</option>
                <option v-for="product in products" :key="product.id" :value="product.id">
                  {{ product.name }}
                </option>
              </select>
            </div>
            <div class="w-48">
              <select v-model="filters.type" class="select-field" @change="filter">
                <option value="">All Types</option>
                <option value="in">Stock In</option>
                <option value="out">Stock Out</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Stock Movements Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="table-header">Product</th>
                <th class="table-header">Type</th>
                <th class="table-header">Quantity</th>
                <th class="table-header">Notes</th>
                <th class="table-header">Recorded By</th>
                <th class="table-header">Date</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="movement in movements.data" :key="movement.id">
                <td class="table-cell">{{ movement.product.name }}</td>
                <td class="table-cell">
                  <span
                    :class="{
                      'px-2 py-1 text-xs font-semibold rounded': true,
                      'bg-green-100 text-green-800': movement.type === 'in',
                      'bg-red-100 text-red-800': movement.type === 'out',
                    }"
                  >
                    {{ movement.type === 'in' ? 'Stock In' : 'Stock Out' }}
                  </span>
                </td>
                <td class="table-cell">{{ movement.quantity }}</td>
                <td class="table-cell">{{ movement.notes || '-' }}</td>
                <td class="table-cell">{{ movement.user.name }}</td>
                <td class="table-cell">{{ formatDate(movement.created_at) }}</td>
              </tr>
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="px-6 py-4">
            <Pagination :links="movements.links" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  movements: Object,
  products: Array,
  filters: Object,
  can: Object,
})

const filters = ref({
  product_id: props.filters.product_id,
  type: props.filters.type,
})

const filter = () => {
  router.get(route('stock-movements.index'), filters.value, {
    preserveState: true,
    preserveScroll: true,
  })
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}
</script>

<style scoped>
.table-header {
  @apply px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
}

.table-cell {
  @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900;
}

.btn-primary {
  @apply inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150;
}

.select-field {
  @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
}
</style>
