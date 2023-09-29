import useApi from 'src/composables/UseApi'

export default function productsService () {
  const { getAll, save, update, remove } = useApi('categories')

  return {
    getAll,
    save,
    update,
    remove
  }
}
