import { useContext } from 'react'
import { OptionsContext } from '../context/OptionsContext'

const WordPress = () => {
    const { options, handleChange } = useContext(OptionsContext)

    return (
        <>
            {/* WP block library */}
            <div>
                <p>Disable wp block library</p>
                <span>This option will disable WP Block Library (Does not include single posts).</span>
                <input
                    type='checkbox'
                    name='wpBlockLibrary'
                    className='pr-checkbox'
                    id='wpBlockLibrary'
                    checked={options.wpBlockLibrary}
                    onChange={handleChange}
                />
            </div>

            {/* jQuery migrate */}
            <div>
                <p>Disable jQuery migrate</p>
                <span>This option will disable jQuery Migrate.</span>
                <input
                    type='checkbox'
                    name='jQueryMigrate'
                    className='pr-checkbox'
                    id='jQueryMigrate'
                    checked={options.jQueryMigrate}
                    onChange={handleChange}
                />
            </div>

            {/* Query strings */}
            <div>
                <p>Disable query strings</p>
                <span>This option will disable styles and scripts query strings.</span>
                <input
                    type='checkbox'
                    name='queryString'
                    className='pr-checkbox'
                    id='queryString'
                    checked={options.queryString}
                    onChange={handleChange}
                />
            </div>

            {/* Emoji */}
            <div>
                <p>Disable emoji</p>
                <span>Enabling this option will prevent WP emojis from loading.</span>
                <input
                    type='checkbox'
                    name='emoji'
                    className='pr-checkbox'
                    id='emoji'
                    checked={options.emoji}
                    onChange={handleChange}
                />
            </div>
        </>
    )
}

export default WordPress
