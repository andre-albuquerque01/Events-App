import ApiServer from '@/data/api'
import { redirect } from 'next/navigation'
import { z } from 'zod'

export async function GET(
  _: Request,
  { params }: { params: { email: string } },
) {
  const email = z.string().parse(params.email)

  const response = await ApiServer(`verifyEmail/${email}`, {
    method: 'GET',
  })

  if (response.ok) redirect('/login')
  else redirect('/')
}
