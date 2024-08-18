import { GetAllEvent } from '@/action/events/home/route'
import LinkPagination from '@/components/linkPagination'
import { EventsInterface } from '@/data/types/events'
import { Metadata } from 'next'
import Image from 'next/image'
import Link from 'next/link'

export const metadata: Metadata = {
  title: 'Home',
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

export default async function Home({ searchParams }: PropsSearchParams) {
  let { page: query } = searchParams || 1
  if (query === undefined) query = 1
  const { data, countPage } = (await GetAllEvent(
    query,
  )) as FeaturedEventsResponse

  return (
    <>
      <div className="flex flex-wrap flex-row justify-center gap-6">
        {data &&
          data.length > 0 &&
          data.map((event) => {
            return (
              event.statusEvent === 1 && (
                <Link
                  href={`/events/${event.id}`}
                  className="group relative rounded-lg w-[280px] h-[280px] bg-zinc-800 overflow-hidden flex justify-center"
                  key={event.id}
                >
                  <Image
                    src={event.pathName}
                    className="group-hover:scale-110 transition-transform duration-500 rounded-xl"
                    width={280}
                    height={280}
                    quality={80}
                    alt=""
                  />
                  <div className="absolute bottom-10 right-5 h-12 flex items-center gap-2 max-w-[230px] rounded-full border-2 border-zinc-500 bg-black/60 p-1 pl-5">
                    <span className="text-sm truncate">{event.title}</span>
                    <span className="flex h-full items-center justify-center rounded-full bg-violet-500 px-4 font-semibold">
                      {event.price.toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL',
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 2,
                      })}
                    </span>
                  </div>
                </Link>
              )
            )
          })}
      </div>
      <div className="flex justify-center mt-4 h-10">
        <LinkPagination query={query} countPage={countPage} />
      </div>
    </>
  )
}
