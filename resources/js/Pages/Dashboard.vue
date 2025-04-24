<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  stats: Object,
  recentMovements: Array,
  lowStockProducts: Array,
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="text-sm font-medium text-gray-500">Total Products</div>
              <div class="mt-2 text-3xl font-semibold text-gray-900">{{ stats.totalProducts }}</div>
              <div class="mt-2 text-sm text-gray-600">
                Across {{ stats.totalCategories }} categories
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="text-sm font-medium text-gray-500">Total Stock Value</div>
              <div class="mt-2 text-3xl font-semibold text-gray-900">
                ${{ stats.totalStockValue.toLocaleString() }}
              </div>
              <div class="mt-2 text-sm text-gray-600">
                {{ stats.totalStockItems }} items in stock
              </div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="text-sm font-medium text-gray-500">Low Stock Items</div>
              <div class="mt-2 text-3xl font-semibold text-red-600">
                {{ stats.lowStockItems }}
              </div>
              <div class="mt-2 text-sm text-gray-600">Need attention</div>
            </div>
          </div>

          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <div class="text-sm font-medium text-gray-500">Recent Movements</div>
              <div class="mt-2 text-3xl font-semibold text-gray-900">
                {{ stats.recentMovements }}
              </div>
              <div class="mt-2 text-sm text-gray-600">In the last 24 hours</div>
            </div>
          </div>
        </div>

        <!-- Recent Activity and Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Recent Activity -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
              <div class="mt-6 space-y-4">
                <div v-for="movement in recentMovements" :key="movement.id" class="flex items-center">
                  <div
                    :class="{
                      'w-2 h-2 rounded-full mr-3': true,
                      'bg-green-500': movement.type === 'in',
                      'bg-red-500': movement.type === 'out',
                    }"
                  ></div>
                  <div class="flex-1">
                    <div class="text-sm font-medium text-gray-900">
                      {{ movement.type === 'in' ? 'Stock In' : 'Stock Out' }}: {{ movement.product.name }}
                    </div>
                    <div class="text-sm text-gray-500">
                      Quantity: {{ movement.quantity }} • {{ formatDate(movement.created_at) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-6">
                <Link :href="route('stock-movements.index')" class="text-sm text-indigo-600 hover:text-indigo-900">
                  View all movements →
                </Link>
              </div>
            </div>
          </div>

          <!-- Low Stock Items -->
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
              <h3 class="text-lg font-medium text-gray-900">Low Stock Items</h3>
              <div class="mt-6 space-y-4">
                <div v-for="product in lowStockProducts" :key="product.id" class="flex items-center">
                  <div class="w-2 h-2 rounded-full mr-3 bg-yellow-500"></div>
                  <div class="flex-1">
                    <div class="text-sm font-medium text-gray-900">{{ product.name }}</div>
                    <div class="text-sm text-gray-500">
                      Current Stock: {{ product.quantity }} • Minimum: {{ product.min_quantity }}
                    </div>
                  </div>
                  <Link
                    :href="route('stock-movements.create')"
                    class="text-sm text-indigo-600 hover:text-indigo-900"
                  >
                    Restock →
                  </Link>
                </div>
              </div>
              <div class="mt-6">
                <Link :href="route('products.index')" class="text-sm text-indigo-600 hover:text-indigo-900">
                  View all products →
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
