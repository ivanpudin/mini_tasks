import React, { useContext } from 'react'
import UserContext from './context'

const Button = ({ children }) => {
  const [userState, setUserState] = useContext(UserContext)
  return <button>{children}</button>
}

export default Button
