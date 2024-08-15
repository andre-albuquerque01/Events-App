'use server'
import { revalidateTag } from 'next/cache'
import { cookies } from 'next/headers'
import { z } from 'zod'

export async function DeleteUserEvent(idUserEvents: string) {
  try {
    const id = z.string().parse(idUserEvents)

    const response = await fetch(`userEvents/${id}`, {
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${cookies().get('token')?.value}`,
      },
    })
    const data = await response.json()
    revalidateTag('userEvents')
    return data.data
  } catch (error) {
    console.log('Erro ao analisar JSON:', error)
  }
}
