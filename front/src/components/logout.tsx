'use client'
import { Logout } from '@/action/user/logout/route'
import { LogOut } from 'lucide-react'
import { FormEvent } from 'react'

export default function LogoutComponent() {
  async function handleLogout(e: FormEvent) {
    e.preventDefault()
    await Logout()
  }
  return (
    <div>
      <button className="flex items-center gap-2" onClick={handleLogout}>
        <LogOut className="h-5 w-5" />
        <span className="text-md">Sair</span>
      </button>
    </div>
  )
}
