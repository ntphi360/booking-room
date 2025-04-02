<template>
  <form>
    <div class="mb-4 mt-4 flex flex-wrap gap-2">
      <label class="flex items-center gap-2 cursor-pointer">
        <input id="deleted" v-model="filterForm.deleted" type="checkbox"
          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
        Deleted
      </label>
      <div>
        <select class="input-filter-l w-24" v-model="filterForm.by">
          <option value="created_at">Added</option>
          <option value="price">Price</option>
        </select>
        <select class="input-filter-l w-32" v-model="filterForm.order">
          <option v-for="option in sortOptions" :key="option.value" :value="option.value">
            {{ option.label }}
          </option>
        </select>
      </div>
    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed, reactive, watch } from 'vue';
import {router} from '@inertiajs/vue3';

const sortLabels = { 
  created_at: [
    {
      label:'Lastest',
      value:'desc',
    },
    {
      label:'Oldest',
      value:'asc'
    }
  ],
  price: [
    {
      label:'Pricy',
      value:'desc',
    },
    {
      label:'Cheapest',
      value:'asc'
    }
  ]
}

const sortOptions = computed(() => sortLabels[filterForm.by])

const filterForm = reactive({
  deleted: false,
  by: 'created_at',
  order: 'desc',
})

const debounce = (func, wait = 500) => {
  let timeout
  return (...args) => {
    clearTimeout(timeout)
    timeout = setTimeout(() => func(...args), wait)
  }
}


watch(filterForm, () => {
  debounce(() => {
    router.get(route('realtor.listings.index'), filterForm, {
      preserveState: true, 
      preserveScroll: true
    });
  })();
}, { deep: true });
</script>
