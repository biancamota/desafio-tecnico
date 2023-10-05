import useApi from 'src/composables/UseApi'

export default function productsService () {
  const { getAll, save, update, remove, getById } = useApi('products')

  return {
    getAll,
    save,
    update,
    remove,
    getById
  }
}
