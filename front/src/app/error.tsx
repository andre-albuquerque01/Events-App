'use client'
import { useEffect } from 'react'

export default function Error({
  error,
  reset,
}: {
  error: Error & { digest?: string }
  reset: () => void
}) {
  useEffect(() => {
    console.error(error)
  }, [error])

  return (
    <div className="flex flex-col justify-center items-center h-screen gap-3 bg-zinc-800">
      <h1 className="text-white text-center text-2xl">
        Olá! Desculpe, infelizmente aconteceu algo não esperado.
      </h1>
      <button
        onClick={() => reset()}
        className="bg-blue-600 px-4 py-2 rounded-md text-white hover:bg-blue-900"
      >
        Tente novamente
      </button>
    </div>
  )
}
