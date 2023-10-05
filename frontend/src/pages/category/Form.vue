<template>
  <q-page padding>
    <div class="row justify-center">
      <div class="col-12 text-center">
        <p class="text-h6">
          Form Category
        </p>
      </div>
      <q-form class="col-md-7 col-xs-12 col-sm-12 q-gutter-y-md" @submit.prevent="handleSubmit">

       <q-input
          label="Name"
          v-model="form.name"
          :rules="[val => (val && val.length > 0) || 'Name is required']"
        />

        <q-input
          label="Taxe"
          v-model="form.taxe"
          :rules="[val => !!val || 'Taxe is required']"
          prefix="%"
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
          :to="{ name: 'categoriesList' }"
        />

      </q-form>
    </div>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import useNotify from 'src/composables/UseNotify'
import categoriesService from 'src/services/category'

export default defineComponent({
  name: 'PageProductForm',
  setup () {
    const router = useRouter()
    const route = useRoute()
    const service = categoriesService()
    const { notifyError, notifySuccess } = useNotify()

    const isUpdate = computed(() => route.params.id)

    let category = {}
    const form = ref({
      name: '',
      taxe: 0,
    })

    onMounted(() => {
      if (isUpdate.value) {
        handleGetCategory(isUpdate.value)
      }
    })

    const handleSubmit = async () => {
      try {
        if (isUpdate.value) {
          await service.update(form.value)
          notifySuccess('Update Successfully')
        } else {
          await service.save(form.value)
          notifySuccess('Saved Successfully')
        }
        router.push({ name: 'categoriesList' })
      } catch (error) {
        notifyError(error.message)
      }
    }

    const handleGetCategory = async (id) => {
      try {
        category = await service.getById(id)
        form.value = category
      } catch (error) {
        notifyError(error.message)
      }
    }

    return {
      handleSubmit,
      form,
      isUpdate
    }
  }
})
</script>
