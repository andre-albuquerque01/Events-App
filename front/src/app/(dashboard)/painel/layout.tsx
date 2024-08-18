import { cookies } from 'next/headers'
import { redirect } from 'next/navigation'
import { ReactNode } from 'react'

export default function Dashboard({ children }: { children: ReactNode }) {
  const cookiesList = cookies()
  const hasCookie = cookiesList.has('token')
  const hasCookieRole = cookiesList.get('r')
  if (!hasCookie || hasCookieRole?.value !== 'JesusIsKingADM')
    redirect('/login')

  return <div>{children}</div>
}
