'use server'
import ApiServer from '@/data/api'
import { z } from 'zod'

export async function GetEvent(idEvent: string) {
  try {
    // await new Promise((resolve) => setTimeout(resolve, 1000))
    const id = z.string().parse(idEvent)

    const response = await ApiServer(`events/${id}`, {
      next: {
        revalidate: 60 * 30,
        tags: ['events'],
      },
    })
    const data = await response.json()

    if (!response) {
      return Response.json({ message: 'Event not found.' }, { status: 400 })
    }

    return data.data
  } catch (e) {
    return { message: 'Error while fetching event.' }
  }
}
