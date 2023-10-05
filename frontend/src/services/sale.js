import useApi from 'src/composables/UseApi'
import { api } from 'boot/axios'

export default function salesService () {
  const { getAll, save, update, remove, getById } = useApi('sales')

  return {
    getAll,
    save,
    update,
    remove,
    getById
  }
}
