import React, { useContext } from 'react'
import { NavLink } from 'react-router-dom'
import { UserContext } from './context'

const Header = ({ logout }) => {
  const [userState, setUserState] = useContext(UserContext)

  return (
    <header>
      <nav>
        <ul>
          <li>
            <NavLink to="/tasks/">Home</NavLink>
          </li>
          <li>
            <NavLink to="/your-tasks/">Your tasks</NavLink>
          </li>
          <li>
            <NavLink to="/create-task/">Create task</NavLink>
          </li>
        </ul>
      </nav>
      {userState.id && (
        <div>
          <p>
            Welcome, {userState.firstname} {userState.lastname}
          </p>
          <button onClick={logout}>Logout</button>
        </div>
      )}
    </header>
  )
}

export default Header
