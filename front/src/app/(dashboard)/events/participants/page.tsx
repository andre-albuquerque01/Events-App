import { GetShowUserEvents } from '@/action/events/hasEvent/getShowUserEvents/route'
import ButtonPainelDeleteHasEvent from '@/components/button-delete-hasEvent'
import LinkPaginationPainel from '@/components/linkPaginationPainel'
import { EventsInterface } from '@/data/types/events'
import { Metadata } from 'next'
import Image from 'next/image'
import Link from 'next/link'

export const metadata: Metadata = {
  title: 'Dashboard',
}
interface PropsSearchParams {
  searchParams: {
    page: number
  }
}

interface FeaturedEventsResponse {
  data: EventsInterface[]
  countPage: number
}

export default async function HasEventUser({
  searchParams,
}: PropsSearchParams) {
  let { page: query } = searchParams || 1
  if (query === undefined) query = 1
  const { data, countPage } = (await GetShowUserEvents(
    query,
  )) as FeaturedEventsResponse

  return (
    <>
      <div className="flex flex-col gap-4">
        <p className="font-sm">Lista dos eventos participando</p>
        <div className="flex flex-row justify-center flex-wrap gap-6">
          {data && data.length > 0 ? (
            data.map((eventos) => (
              <>
                <Link
                  href={`/events/${eventos.id}`}
                  className="group relative rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center items-end"
                  key={eventos.event.idEvents}
                >
                  <Image
                    src={eventos.event.pathName}
                    className="group-hover:scale-110 transition-transform duration-500"
                    width={350}
                    height={350}
                    quality={100}
                    alt=""
                  />
                  <div className="absolute top-1 right-5 h-12 flex items-center max-w-[50px] rounded-xl border-2 border-zinc-500 bg-black/60 p-1">
                    <ButtonPainelDeleteHasEvent
                      idHasEvents={eventos.idHasEvents}
                    />
                  </div>
                  <div className="absolute bottom-10 right-5 h-12 flex items-center gap-2 max-w-[240px] rounded-full border-2 border-zinc-500 bg-black/60 p-1 pl-5">
                    <span className="text-sm truncate">
                      {eventos.event.title}
                    </span>
                    <span className="flex h-full items-center justify-center rounded-full bg-violet-500 px-4 font-semibold">
                      {eventos.event.price?.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2,
                      })}
                    </span>
                  </div>
                </Link>
              </>
            ))
          ) : (
            <p className="font-sm">Não está participando de nenhum evento.</p>
          )}
        </div>
      </div>
      <div className="flex justify-center mt-4 h-10">
        <LinkPaginationPainel query={query} countPage={countPage} />
      </div>
    </>
  )
}
