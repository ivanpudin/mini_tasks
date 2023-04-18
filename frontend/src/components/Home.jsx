import { NavLink } from 'react-router-dom'

const Home = () => {
    return(
        <div className="Home">
            <NavLink to='/convertor'>
                <h2>convert</h2>
            </NavLink>
            <NavLink to='/contact'>
                <h2>contact</h2>
            </NavLink>
            <NavLink to='/todo'>
                <h2>to do</h2>
            </NavLink>
        </div>
    )
}

export default Home