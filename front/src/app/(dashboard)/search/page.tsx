import { GetEventSearch } from '@/action/events/search/route'
import { EventsInterface } from '@/data/types/events'
import Image from 'next/image'
import Link from 'next/link'
import { redirect } from 'next/navigation'

interface SearchProps {
  searchParams: {
    q: string
  }
}

export default async function Search({ searchParams }: SearchProps) {
  const { q: query } = searchParams
  const events = (await GetEventSearch(query)) as EventsInterface[]

  if (!query) redirect('/')

  return (
    <div className="flex flex-col gap-4">
      <p className="font-sm">
        Resultado para: <span className="font-semibold">{query}</span>
      </p>

      <div className="flex flex-row flex-wrap gap-6">
        {events && events.length > 0 ? (
          events.map(
            (eventos) =>
              eventos.statusEvent === 1 && (
                <Link
                  href={`/events/${eventos.idEvents}`}
                  className="group relative rounded-lg w-[400px] h-[400px] bg-zinc-800 overflow-hidden flex justify-center items-end"
                  key={eventos?.id}
                >
                  <Image
                    src={eventos.pathName}
                    className="group-hover:scale-105 transition-transform duration-500"
                    width={480}
                    height={480}
                    quality={100}
                    alt=""
                  />
                  <div className="absolute bottom-10 right-10 h-12 flex items-center gap-2 max-w-[280px] rounded-full border-2 border-zinc-500 bg-black/60 p-1 pl-5">
                    <span className="text-sm truncate">{eventos?.title}</span>
                    <span className="flex h-full items-center justify-center rounded-full bg-violet-500 px-4 font-semibold">
                      {eventos?.price.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2,
                      })}
                    </span>
                  </div>
                </Link>
              ),
          )
        ) : (
          <p className="font-2xl">Nenhum resultado encontrado</p>
        )}
      </div>
    </div>
  )
}
