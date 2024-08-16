import { NextRequest, NextResponse } from 'next/server'

export async function middleware(request: NextRequest) {
  const token = request.cookies.get('token')?.value
  const r = request.cookies.get('r')?.value
  const authenticated =
    token !== undefined && token.length >= 49 && token.length <= 53
  const autorization = r === 'JesusIsKingADM'
  if (
    !autorization &&
    (request.nextUrl.pathname.startsWith('/painel') ||
      request.nextUrl.pathname.startsWith('/events/whoParticipant') ||
      request.nextUrl.pathname.startsWith('/events/insert') ||
      request.nextUrl.pathname.startsWith('/events/update'))
  ) {
    return NextResponse.redirect(new URL('/configuration', request.url))
  }

  if (
    !authenticated &&
    (request.nextUrl.pathname.startsWith('/configuration') ||
      request.nextUrl.pathname.startsWith('/events/participants') ||
      request.nextUrl.pathname.startsWith('/painel') ||
      request.nextUrl.pathname.startsWith('/events/whoParticipant') ||
      request.nextUrl.pathname.startsWith('/events/insert') ||
      request.nextUrl.pathname.startsWith('/user/update') ||
      request.nextUrl.pathname.startsWith('/events/update'))
  ) {
    return NextResponse.redirect(new URL('/login', request.url))
  }
  return NextResponse.next()
}

export const config = {
  matcher: [
    '/painel/:path*',
    '/events/whoParticipant',
    '/events/update',
    '/events/insert',
  ],
}
