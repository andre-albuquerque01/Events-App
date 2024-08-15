'use server'
import ApiServer from '@/data/api'
import { revalidateTag } from 'next/cache'
import { cookies } from 'next/headers'
import { z } from 'zod'

export async function DeleteEvent(idEvent: string) {
  try {
    const id = z.string().parse(idEvent)

    const cookiesStore = cookies()
    const token = cookiesStore.get('token')

    await ApiServer(`events/${id}`, {
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${token?.value}`,
      },
    })
    revalidateTag('events')
    return { message: 'Sucess.' }
  } catch (error) {
    console.log('Erro ao analisar JSON:', error)
  }
}
