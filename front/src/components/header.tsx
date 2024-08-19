import Link from 'next/link'
import React from 'react'
import { CircleUser } from 'lucide-react'
import CartWidget from './cart-widget'
import SearchForm from './search-form'
import { cookies } from 'next/headers'

export default function header() {
  const cookiesList = cookies()
  const hasCookie = cookiesList.has('token')
  return (
    <div>
      <div className="flex items-center justify-between">
        <div className="flex items-center gap-5">
          <Link
            href="/"
            className="text-2xl max-md:text-xl font-extrabold text-white"
          >
            Events Ibe
          </Link>
          <div className="max-md:hidden">
            <SearchForm />
          </div>
        </div>

        <div className="flex items-center gap-4">
          {/* <CartWidget />
          <div className="w-px h-4 bg-zinc-500"></div> */}
          {hasCookie ? (
            <Link
              href="/configuration"
              className="flex items-center gap-2 hover:underline"
            >
              <span className="text-sm max-md:hidden">Conta</span>
              <CircleUser className="h-6 w-6" />
            </Link>
          ) : (
            <Link
              href="/login"
              className="flex items-center gap-2 hover:underline"
            >
              <span className="text-sm max-md:hidden">Login</span>
              <CircleUser className="h-6 w-6" />
            </Link>
          )}
        </div>
      </div>
    </div>
  )
}
