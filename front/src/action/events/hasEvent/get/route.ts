'use server'
import ApiServer from '@/data/api'
import { cookies } from 'next/headers'

export async function GetUserEventsPage(page: number) {
  try {
    const response = await ApiServer(`userEvents?page=${page}`, {
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

    const data = await response.json()
    console.log(data)
    return data.data
  } catch (error) {
    console.error(error)
  }
}
