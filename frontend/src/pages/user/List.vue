<template>
  <q-page padding>
    <div class="row">
      <q-table
        :rows="users"
        :columns="columnsUser"
        row-key="id"
        class="col-12"
        :loading="loading"
      >
        <template v-slot:top>
          <span class="text-h6">
            Users
          </span>
          <q-space />
          <q-btn
            label="Add New"
            color="primary"
            dense
            :to="{ name: 'usersForm' }"
          />
        </template>
        <template v-slot:body-cell-actions="props">
          <q-td :props="props" class="q-gutter-x-sm">
            <q-btn icon="mdi-pencil-outline" color="info" dense size="sm" @click="handleEdit(props.row)">
              <q-tooltip>
                Edit
              </q-tooltip>
            </q-btn>
            <q-btn icon="mdi-delete-outline" color="negative" dense size="sm" @click="handleRemoveItem(props.row)">
              <q-tooltip>
                Delete
              </q-tooltip>
            </q-btn>
          </q-td>
        </template>
      </q-table>
    </div>
  </q-page>
</template>

<script>
import { defineComponent, ref, onMounted } from 'vue'
import useNotify from 'src/composables/UseNotify'
import { useRouter } from 'vue-router'
import { useQuasar} from 'quasar'
import { columnsUser } from './table'
import usersService from 'src/services/user'

export default defineComponent({
  name: 'PageUserList',
  setup () {
    const users = ref([])
    const loading = ref(true)
    const router = useRouter()
    const $q = useQuasar()

    const service = usersService()
    const { notifyError, notifySuccess } = useNotify()

    const handleList = async () => {
      try {
        loading.value = true
        users.value = await service.getAll()
        loading.value = false
      } catch (error) {
        notifyError(error.message)
      }
    }

    const handleEdit = (item) => {
      router.push({ name: 'usersForm', params: { id: item.id } })
    }

    const handleRemoveItem = async (item) => {
      try {
        $q.dialog({
          title: 'Confirm',
          message: `Do you really delete ${item.name} ?`,
          cancel: true,
          persistent: true
        }).onOk(async () => {
          await service.remove(item.id)
          notifySuccess('successfully deleted')
          handleList()
        })
      } catch (error) {
        notifyError(error.message)
      }
    }

    onMounted(() => {
      handleList()
    })

    return {
      columnsUser,
      users,
      loading,
      handleEdit,
      handleRemoveItem,
    }
  }
})
</script>
