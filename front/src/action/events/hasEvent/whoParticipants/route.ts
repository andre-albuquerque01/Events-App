'use server'
import ApiServer from '@/data/api'
import { cookies } from 'next/headers'

export async function GetOneUserEvents(id: string) {
  try {
    const response = await ApiServer(`userEvents/${id}`, {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${cookies().get('token')?.value}`,
        'Content-Type': 'application/json',
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
    return ''
  }
}
