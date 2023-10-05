<template>
  <q-page padding>
    <div class="row justify-center">
      <div class="col-12 text-center">
        <p class="text-h6">
          Form User
        </p>
      </div>
      <q-form class="col-md-7 col-xs-12 col-sm-12 q-gutter-y-md" @submit.prevent="handleSubmit">

        <q-input
          label="Name"
          v-model="form.name"
          lazy-rules
          :rules="[val => (val && val.length > 0) || 'Name is required']"
        />

        <q-input
          label="Email"
          v-model="form.email"
          lazy-rules
          :rules="[val => (val && val.length > 0) || 'Email is required']"
          type="email"
        />

        <q-input
          label="Password"
          v-model="form.password"
          lazy-rules
          :rules=" isUpdate ? [] : [val => (val && val.length >= 6) || 'Password is required and 6 characters']"
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
          :to="{ name: 'usersList' }"
        />

      </q-form>
    </div>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import useNotify from 'src/composables/UseNotify'
import usersService from 'src/services/user'

export default defineComponent({
  name: 'PageUserForm',
  setup () {
    const router = useRouter()
    const route = useRoute()
    const service = usersService()
    const { notifyError, notifySuccess } = useNotify()

    const isUpdate = computed(() => route.params.id)

    let user = {}
    const form = ref({
      name: '',
      email: '',
      password: ''
    })

    onMounted(() => {
      if (isUpdate.value) {
        handleGetUser(isUpdate.value)
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
        router.push({ name: 'usersList' })
      } catch (error) {
        notifyError(error.message)
      }
    }

    const handleGetUser = async (id) => {
      try {
        user = await service.getById(id)
        form.value = user
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
