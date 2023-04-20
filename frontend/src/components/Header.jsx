import React, { useContext  } from 'react'
import { NavLink, useNavigate } from 'react-router-dom'
import { UserContext } from '../context'
import '../assets/css/Header.css'

const Header = (props) => {
  const [userState, setUserState] = useContext(UserContext)
  const navigate = useNavigate()

  return (
    <div>
      {props.headerState && <header>
        <h2>camel_case</h2>
        <a href={this} onClick={props.handleOverlay}>Back</a>
      </header>}


      {!props.headerState && <header>
        <nav>
          <ul>
            <li>
              <NavLink to="/todo/tasks/">All</NavLink>
            </li>
            <li>
              <NavLink to="/todo/your-tasks/">Your</NavLink>
            </li>
            <li>
              <NavLink to="/todo/create-task/">Create task</NavLink>
            </li>
            <li>
              <NavLink to='/todo/create_user'>Create user</NavLink>
            </li>
            <li>
              <a href={this} onClick={props.handleOverlay}>Back</a>
            </li>
          </ul>
        </nav>
        {userState.id && (
          <div className='logout'>
            <p>
              Welcome, {userState.firstname} {userState.lastname}
            </p>
            <button onClick={props.logout}>Logout</button>
          </div>
        )}
      </header>}
    </div>
  )
}

export default Header
