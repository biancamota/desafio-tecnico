<template>
  <q-page padding>
    <div class="row justify-center">
      <div class="col-12 text-center">
        <p class="text-h6">
          Form Product
        </p>
      </div>
      <q-form class="col-md-7 col-xs-12 col-sm-12 q-gutter-y-md" @submit.prevent="handleSubmit">

       <q-input
          label="Name"
          v-model="form.name"
          :rules="[val => (val && val.length > 0) || 'Name is required']"
        />

        <q-input
          label="Price"
          v-model="form.price"
          :rules="[val => !!val || 'Price is required']"
          prefix="$"
        />

        <q-select
          v-model="form.category_id"
          :options="optionsCategory"
          label="Category"
          option-value="id"
          option-label="name"
          map-options
          emit-value
          :rules="[val => !!val || 'Category is required']"
        />

        <q-btn
          :label="isUpdate ? 'Update' : 'Save'"
          color="primary"
          class="full-width"
          rounded
          type="submit"
        />

        <q-btn
          label="Cancel"
          color="primary"
          class="full-width"
          rounded
          flat
          :to="{ name: 'productsList' }"
        />

      </q-form>
    </div>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import useNotify from 'src/composables/UseNotify'
import productsService from 'src/services/products'
import categoriesService from 'src/services/category'

export default defineComponent({
  name: 'PageProductForm',
  setup () {
    const router = useRouter()
    const route = useRoute()
    const service = productsService()
    const serviceCategory = categoriesService()
    const { notifyError, notifySuccess } = useNotify()

    const isUpdate = computed(() => route.params.id)

    let product = {}
    const optionsCategory = ref([])
    const form = ref({
      name: '',
      price: 0,
      category_id: ''
    })

    onMounted(() => {
      handleListCategories()
      if (isUpdate.value) {
        handleGetProduct(isUpdate.value)
      }
    })

    const handleListCategories = async () => {
      optionsCategory.value = await serviceCategory.getAll()
    }

    const handleSubmit = async () => {
      try {
        if (isUpdate.value) {
          await service.update(form.value)
          notifySuccess('Update Successfully')
        } else {
          await service.save(form.value)
          notifySuccess('Saved Successfully')
        }
        router.push({ name: 'productsList' })
      } catch (error) {
        notifyError(error.message)
      }
    }

    const handleGetProduct = async (id) => {
      try {
        product = await service.getById(id)
        form.value = product
      } catch (error) {
        notifyError(error.message)
      }
    }

    return {
      handleSubmit,
      form,
      isUpdate,
      optionsCategory
    }
  }
})
</script>
