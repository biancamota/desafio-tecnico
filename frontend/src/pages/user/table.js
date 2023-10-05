import { ref } from 'vue'

const columnsUser = [
  { name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true },
  { name: 'email', align: 'left', label: 'Email', field: 'email', sortable: true },
  { name: 'actions', align: 'right', label: 'Actions', field: 'actions', sortable: false }
]

const initialPagination = ref({
  page: 1,
  rowsPerPage: 8
})

export {
  columnsUser,
  initialPagination
}
