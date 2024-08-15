'use server'
import ApiServer from '@/data/api'

export async function GetAllEvent(page: number) {
  try {
    const response = await ApiServer(`events?page=${page}`, {
      next: {
        revalidate: 60 * 30,
        tags: ['events'],
      },
    })
    const datas = await response.json()
    const countPage = datas.meta.last_page
    const data = datas.data

    return { data, countPage }
  } catch (error) {
    return { data: [], countPage: 0 }
  }
}
