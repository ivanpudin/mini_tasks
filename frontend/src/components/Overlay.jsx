import { NavLink } from 'react-router-dom'
import placeholder1 from '../assets/content/placeholder1.jpg'
import placeholder2 from '../assets/content/placeholder2.jpg'
import placeholder3 from '../assets/content/placeholder3.jpg'

const Overlay = (props) => {
    return(
        <div className={props.overlay ? 'Overlay overlay_in' : 'Overlay overlay_out'}>
            <NavLink
            to='/convertor'
            onClick={props.handleOverlay}
            className={props.overlay ? 'tile1_in' : 'tile1_out'}>
                <div class="container">
                    <img src={placeholder1} alt="placeholder" />
                    <h1>Convertor</h1>
                </div>
            </NavLink>
            <NavLink
            to='/contact'
            onClick={props.handleOverlay}
            className={props.overlay ? 'tile2_in' : 'tile2_out'}>
                <div class="container">
                    <img src={placeholder2} alt="placeholder" />
                    <h1>Contact us</h1>
                </div>
            </NavLink>
            <NavLink
            to='/todo/tasks'
            onClick={props.handleOverlay}
            className={props.overlay ? 'tile3_in' : 'tile3_out'}>
                <div class="container">
                    <img src={placeholder3} alt="placeholder" />
                    <h1>To do list</h1>
                </div>
            </NavLink>
        </div>
    )
}

export default Overlay