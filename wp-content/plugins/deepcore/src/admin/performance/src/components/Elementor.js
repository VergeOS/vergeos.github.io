import { useContext } from 'react'
import { OptionsContext } from '../context/OptionsContext'

const Elementor = () => {
    const { options, handleChange } = useContext(OptionsContext)

    return (
        <>
            {/* Google fonts */}
            <div>
                <p>Disable Google fonts</p>
                <span>Enabling this option will prevent Elementor Google fonts from loading.</span>
                <input
                    type='checkbox'
                    name='googleFonts'
                    className='pr-checkbox'
                    id='googleFonts'
                    checked={options.googleFonts}
                    onChange={handleChange}
                />
            </div>

            {/* Icons */}
            <div>
                <p>Disable Icons</p>
                <span>Enabling this option will prevent Elementor icons from loading.</span>
                <input
                    type='checkbox'
                    name='icons'
                    className='pr-checkbox'
                    id='icons'
                    checked={options.icons}
                    onChange={handleChange}
                />
            </div>

            {/* Animations */}
            <div>
                <p>Disable Animations</p>
                <span>Enabling this option will disable Elementor animations on your website.</span>
                <input
                    type='checkbox'
                    name='animations'
                    className='pr-checkbox'
                    id='animations'
                    checked={options.animations}
                    onChange={handleChange}
                />
            </div>

            {/* Frontend script */}
            <div>
                <p>Disable frontend script</p>
                <span>Enabling this option will prevent Elementor fronend scripts (dialog, swiper, share link) from loading.</span>
                <input
                    type='checkbox'
                    name='frontendScript'
                    className='pr-checkbox'
                    id='frontendScript'
                    checked={options.frontendScript}
                    onChange={handleChange}
                />
            </div>

            {/* Font awesome */}
            <div>
                <p>Disable font awesome</p>
                <span>Enabling this option will prevent Elementor font awesome from loading.</span>
                <input
                    type='checkbox'
                    name='fontAwesome'
                    className='pr-checkbox'
                    id='fontAwesome'
                    checked={options.fontAwesome}
                    onChange={handleChange}
                />
            </div>

            {/* Elementor pro script */}
            <div>
                <p>Disable Elementor pro script</p>
                <span>By enabling this option, some features of Elementor may stop working.</span>
                <input
                    type='checkbox'
                    name='elProScript'
                    className='pr-checkbox'
                    id='elProScript'
                    checked={options.elProScript}
                    onChange={handleChange}
                />
            </div>

            {/* Elementor editor script */}
            <div>
                <p>Disable Elementor editor script</p>
                <span>By enabling this option, some features of Elementor may stop working on the backend.</span>
                <input
                    type='checkbox'
                    name='elEditorScript'
                    className='pr-checkbox'
                    id='elEditorScript'
                    checked={options.elEditorScript}
                    onChange={handleChange}
                />
            </div>
        </>
    )
}

export default Elementor
