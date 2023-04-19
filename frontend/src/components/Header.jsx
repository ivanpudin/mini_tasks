import React, { useContext } from 'react'
import { NavLink } from 'react-router-dom'
import { UserContext } from '../context'
import '../assets/css/Header.css'

const Header = ({ logout }) => {
  const [userState, setUserState] = useContext(UserContext)

  return (
    <header>
      <nav>
        <ul>
          <li>
            <NavLink to="/todo/tasks/">All tasks</NavLink>
          </li>
          <li>
            <NavLink to="/todo/your-tasks/">Your</NavLink>
          </li>
          <li>
            <NavLink to="/todo/create-task/">Create</NavLink>
          </li>
        </ul>
      </nav>
      {userState.id && (
        <div className='logout'>
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
