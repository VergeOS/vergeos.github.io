import { useContext } from 'react'
import { OptionsContext } from '../context/OptionsContext'
import logo from '../assets/img/webnus-logo.png'

const Header = () => {
    const { handleSave, reset } = useContext(OptionsContext)

    return (
        <div className='deep-woo-header'>
            <div className='dwh-logo'>
                <img src={logo} />
            </div>
            <div className='dwh-actions'>
                <button className='dwh-btn-type1' onClick={handleSave}>Save Changes</button>
                <button className='dwh-btn-type2' onClick={reset}>Reset All</button>
            </div>
        </div>
    )
}

export default Header
