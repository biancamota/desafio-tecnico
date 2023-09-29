import useApi from 'src/composables/UseApi'
import { api } from 'boot/axios'

export default function salesService () {
  const { getAll, save, update, remove } = useApi('sales')

  return {
    getAll,
    save,
    update,
    remove,
    getPaymentMethods
  }
}
