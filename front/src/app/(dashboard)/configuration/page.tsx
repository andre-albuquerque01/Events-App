import Logout from '@/components/logout'
import SearchForm from '@/components/search-form'
import {
  FolderInput,
  Home,
  ListIcon,
  PanelLeftIcon,
  SquarePen,
} from 'lucide-react'
import { cookies } from 'next/headers'
import Link from 'next/link'

export default function Configuration() {
  const cookiesList = cookies()
  const hasCookie = cookiesList.get('r')
  return (
    <div className="flex flex-col gap-5 mt-5">
      <div className="min-md:hidden">
        <SearchForm />
      </div>
      <Link href="/" className="flex items-center gap-2 w-36">
        <Home className="h-5 w-5" />
        <span className="text-md">Home</span>
      </Link>
      <Link href="/user/update" className="flex items-center gap-2 w-36">
        <SquarePen className="h-5 w-5" />
        <span className="text-md">Editar o perfil</span>
      </Link>
      <Link
        href="/events/participants"
        className="flex items-center gap-2 w-48"
      >
        <ListIcon className="h-5 w-5" />
        <span className="text-md">Eventos participando</span>
      </Link>
      {hasCookie && hasCookie?.value === 'JesusIsKingADM' && (
        <>
          <Link href="/events/insert" className="flex items-center gap-2 w-40">
            <FolderInput className="h-5 w-5" />
            <span className="text-md">Cadastro evento</span>
          </Link>
          <Link href="/painel" className="flex items-center gap-2">
            <PanelLeftIcon className="h-5 w-5" />
            <span className="text-md">Painel</span>
          </Link>
        </>
      )}
      <Logout />
    </div>
  )
}
