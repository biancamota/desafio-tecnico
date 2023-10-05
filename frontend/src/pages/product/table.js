import { ref } from 'vue'

const columnsProduct = [
  { name: 'name', align: 'left', label: 'Name', field: 'name', sortable: true },
  { name: 'price', align: 'left', label: 'Price', field: 'price', sortable: true },
  { name: 'category_id', align: 'left', label: 'Category', field: 'category_id', sortable: true },
  { name: 'actions', align: 'right', label: 'Actions', field: 'actions', sortable: false }
]

const initialPagination = ref({
  page: 1,
  rowsPerPage: 8
})

export {
  columnsProduct,
  initialPagination
}
