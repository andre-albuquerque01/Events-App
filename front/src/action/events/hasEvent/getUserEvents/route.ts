'use server'
import ApiServer from '@/data/api'
import { cookies } from 'next/headers'

export async function GetShowUserEvents(page: number) {
  try {
    const response = await ApiServer(`showUserEvents?page=${page}`, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${cookies().get('token')?.value}`,
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      next: {
        revalidate: 60 * 30,
        tags: ['userEvents', 'events'],
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
