import { useContext } from 'react'
import { OptionsContext } from '../context/OptionsContext'

const Optimization = () => {
    const { options, handleChange } = useContext(OptionsContext)

    return (
        <>
            {/* Minify HTML */}
            <div>
                <p>Minify HTML</p>
                <span>This option will minify HTML of your website.</span>
                <input
                    type='checkbox'
                    name='minifyHTML'
                    className='pr-checkbox'
                    id='minifyHTML'
                    checked={options.minifyHTML}
                    onChange={handleChange}
                />
            </div>

            {/* Minify CSS */}
            <div>
                <p>Minify CSS (Pro)</p>
                <span>This option will merge and minify CSS files to reduce HTTP requests.</span>
                <input
                    type='checkbox'
                    name='minifyCSS'
                    className='pr-checkbox'
                    id='minifyCSS'
                    checked={options.minifyCSS}
                    onChange={handleChange}
                />
            </div>

            {/* Minify JS */}
            <div>
                <p>Minify JS (Pro)</p>
                <span>This option will merge and minify JS files to reduce HTTP requests.</span>
                <input
                    type='checkbox'
                    name='minifyJS'
                    className='pr-checkbox'
                    id='minifyJS'
                    checked={options.minifyJS}
                    onChange={handleChange}
                />
            </div>

            {/* Load scripts on user interaction */}
            {/* <label htmlFor="scriptsAction">Load scripts on user interaction</label>
            <input
                type='checkbox'
                name='scriptsAction'
                className='pr-checkbox'
                id='scriptsAction'
                checked={options.scriptsAction}
                onChange={handleChange}
            /> */}

            {/* Lazy load images */}
            <div>
                <p>Lazy load images</p>
                <span>This option will add the lazyload feature to your website images.</span>
                <input
                    type='checkbox'
                    name='lazyLoad'
                    className='pr-checkbox'
                    id='lazyLoad'
                    checked={options.lazyLoad}
                    onChange={handleChange}
                />
            </div>

            {/* Leverage browser caching */}
            <div>
                <p>Leverage browser caching</p>
                <span>If you enable this option it will generate htacess/apache rules for browser cache. (Expired headers should be configured on your server as well).</span>
                <input
                    type='checkbox'
                    name='leverageBrowserCaching'
                    className='pr-checkbox'
                    id='leverageBrowserCaching'
                    checked={options.leverageBrowserCaching}
                    onChange={handleChange}
                />
            </div>

            {/* GZIP Compression */}
            <div>
                <p>GZIP Compression</p>
                <span>If you enable this option it will generate htacess/apache rules for gzip compression. (Compression should be configured on your server as well).</span>
                <input
                    type='checkbox'
                    name='gzip'
                    className='pr-checkbox'
                    id='gzip'
                    checked={options.gzip}
                    onChange={handleChange}
                />
            </div>
        </>
    )
}

export default Optimization
