import Link from 'next/link'

interface PropsPagination {
  query: number
  countPage: number
}

export default function LinkPagination({ query, countPage }: PropsPagination) {
  return (
    <>
      {query > 1 && (
        <Link
          href={`/?page=${query - 1}`}
          className="bg-gray-800 text-white py-2 px-4 mr-2 rounded-md"
        >
          Página anterior
        </Link>
      )}
      {query < countPage && (
        <Link
          href={`/?page=${Number(query) + 1}`}
          className="bg-gray-800 text-white py-2 px-4 rounded-md"
        >
          Próxima página
        </Link>
      )}
    </>
  )
}
