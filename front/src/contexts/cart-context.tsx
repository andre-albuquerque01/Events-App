'use client'
import { ReactNode, createContext, useContext, useState } from 'react'

interface CartItem {
  eventId: number
  quantity: number
}

interface CartContextType {
  items: CartItem[]
  addToCart: (eventId: number) => void
}

const CartContext = createContext({} as CartContextType)

export function CartProvider({ children }: { children: ReactNode }) {
  const [cartItems, setCartItems] = useState<CartItem[]>([])

  function addToCart(eventId: number) {
    setCartItems((state) => {
      const eventInCart = state.some((item) => item.eventId === eventId)
      if (eventInCart) {
        return state.map((item) => {
          if (item.eventId === eventId) {
            return { ...item, quantity: item.quantity + 1 }
          } else {
            return item
          }
        })
      } else {
        return [...state, { eventId, quantity: 1 }]
      }
    })
  }
  return (
    <CartContext.Provider value={{ items: cartItems, addToCart }}>
      {children}
    </CartContext.Provider>
  )
}

export const useCart = () => useContext(CartContext)
