'use server'
import ApiServer from '@/data/api'
import { redirect } from 'next/navigation'
import { z } from 'zod'

export async function VerifyEmail(emailVerify: string) {
  try {
    const email = z.string().parse(emailVerify)

    const response = await ApiServer(`verifyEmail/${email}`)

    if (response.ok) return redirect('/login')
    else return redirect('/')
  } catch (e) {
    return { message: 'Error while fetching event.' }
  }
}
