<template>
  <form>
    <div class="mb-4 mt-4 flex flex-wrap gap-2">
      <label class="flex items-center gap-2 cursor-pointer">
        <input id="deleted" v-model="filterForm.deleted" type="checkbox"
          class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
        Deleted
      </label>

    </div>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { reactive, watch } from 'vue';
import {router} from '@inertiajs/vue3';


const filterForm = reactive({
  deleted: false,
})

const debounce = (func, wait = 1000) => {
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
