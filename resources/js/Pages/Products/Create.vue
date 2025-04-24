<template>
  <AppLayout title="Create Product">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Product</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <form @submit.prevent="submit" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Basic Information -->
              <div class="space-y-6">
                <div>
                  <label for="name" class="form-label">Name</label>
                  <input
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="input-field"
                    :class="{ 'border-red-500': form.errors.name }"
                  />
                  <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">
                    {{ form.errors.name }}
                  </div>
                </div>

                <div>
                  <label for="sku" class="form-label">SKU</label>
                  <input
                    id="sku"
                    v-model="form.sku"
                    type="text"
                    class="input-field"
                    :class="{ 'border-red-500': form.errors.sku }"
                  />
                  <div v-if="form.errors.sku" class="text-red-500 text-sm mt-1">
                    {{ form.errors.sku }}
                  </div>
                </div>

                <div>
                  <label for="price" class="form-label">Price</label>
                  <input
                    id="price"
                    v-model="form.price"
                    type="number"
                    step="0.01"
                    class="input-field"
                    :class="{ 'border-red-500': form.errors.price }"
                  />
                  <div v-if="form.errors.price" class="text-red-500 text-sm mt-1">
                    {{ form.errors.price }}
                  </div>
                </div>

                <div>
                  <label for="quantity" class="form-label">Initial Quantity</label>
                  <input
                    id="quantity"
                    v-model="form.quantity"
                    type="number"
                    class="input-field"
                    :class="{ 'border-red-500': form.errors.quantity }"
                  />
                  <div v-if="form.errors.quantity" class="text-red-500 text-sm mt-1">
                    {{ form.errors.quantity }}
                  </div>
                </div>
              </div>

              <!-- Additional Information -->
              <div class="space-y-6">
                <div>
                  <label for="category_id" class="form-label">Category</label>
                  <select
                    id="category_id"
                    v-model="form.category_id"
                    class="select-field"
                    :class="{ 'border-red-500': form.errors.category_id }"
                  >
                    <option value="">Select Category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                      {{ category.name }}
                    </option>
                  </select>
                  <div v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">
                    {{ form.errors.category_id }}
                  </div>
                </div>

                <div>
                  <label for="vendor_id" class="form-label">Vendor</label>
                  <select
                    id="vendor_id"
                    v-model="form.vendor_id"
                    class="select-field"
                    :class="{ 'border-red-500': form.errors.vendor_id }"
                  >
                    <option value="">Select Vendor</option>
                    <option v-for="vendor in vendors" :key="vendor.id" :value="vendor.id">
                      {{ vendor.name }}
                    </option>
                  </select>
                  <div v-if="form.errors.vendor_id" class="text-red-500 text-sm mt-1">
                    {{ form.errors.vendor_id }}
                  </div>
                </div>

                <div>
                  <label for="description" class="form-label">Description</label>
                  <textarea
                    id="description"
                    v-model="form.description"
                    rows="4"
                    class="input-field"
                    :class="{ 'border-red-500': form.errors.description }"
                  ></textarea>
                  <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">
                    {{ form.errors.description }}
                  </div>
                </div>

                <div>
                  <label for="image" class="form-label">Product Image</label>
                  <input
                    id="image"
                    type="file"
                    @input="form.image = $event.target.files[0]"
                    accept="image/*"
                    class="input-field"
                    :class="{ 'border-red-500': form.errors.image }"
                  />
                  <div v-if="form.errors.image" class="text-red-500 text-sm mt-1">
                    {{ form.errors.image }}
                  </div>
                </div>
              </div>
            </div>

            <div class="mt-6 flex justify-end space-x-4">
              <Link :href="route('products.index')" class="btn-secondary">Cancel</Link>
              <button type="submit" class="btn-primary" :disabled="form.processing">
                {{ form.processing ? 'Creating...' : 'Create Product' }}
              </button>
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
  categories: Array,
  vendors: Array,
})

const form = useForm({
  name: '',
  sku: '',
  description: '',
  price: '',
  quantity: 0,
  category_id: '',
  vendor_id: '',
  image: null,
})

const submit = () => {
  form.post(route('products.store'))
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
