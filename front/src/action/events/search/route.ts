'use server'
import ApiServer from '@/data/api'

export async function GetEventSearch(title: string) {
  try {
    // await new Promise((resolve) => setTimeout(resolve, 5000))

    const response = await ApiServer(`showTitle/${title}`, {
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
  } catch (error) {
    return ''
  }
}
