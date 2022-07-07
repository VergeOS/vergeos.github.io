import { createContext } from 'react'
import toast from 'react-hot-toast'
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

const axios = require('axios')
const confirm = withReactContent(Swal)

export const OptionsContext = createContext()

class OptionsContextProvider extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            leverageBrowserCaching: '',
            wpBlockLibrary: '',
            frontendScript: '',
            elEditorScript: '',
            jQueryMigrate: '',
            googleFonts: '',
            fontAwesome: '',
            elProScript: '',
            queryString: '',
            animations: '',
            minifyHTML: '',
            scriptsAction: '',
            icons: '',
            emoji: '',
            gzip: '',
            lazyLoad: '',
            minifyCSS: '',
            minifyJS: '',
            styles: [],
            scripts: []
        };
    }

    fetchOptions = async () => {
        const URL = deepSettings.url + 'deep-performance/settings';
        const response = await fetch(URL, {
            headers: {
              'X-WP-Nonce': deepSettings.nonce
            },
        });
        const data = await response.json();
        this.setState({leverageBrowserCaching: data.leverageBrowserCaching});
        this.setState({frontendScript: data.frontendScript});
        this.setState({wpBlockLibrary: data.wpBlockLibrary});
        this.setState({elEditorScript: data.elEditorScript});
        this.setState({jQueryMigrate: data.jQueryMigrate});
        this.setState({fontAwesome: data.fontAwesome});
        this.setState({googleFonts: data.googleFonts});
        this.setState({elProScript: data.elProScript});
        this.setState({queryString: data.queryString});
        this.setState({animations: data.animations});
        this.setState({minifyHTML: data.minifyHTML});
        this.setState({scriptsAction: data.scriptsAction});
        this.setState({icons: data.icons});
        this.setState({emoji: data.emoji});
        this.setState({gzip: data.gzip});
        this.setState({lazyLoad: data.lazyLoad});
        this.setState({minifyCSS: data.minifyCSS});
        this.setState({minifyJS: data.minifyJS});
        this.setState({styles: data.styles});
        this.setState({scripts: data.scripts});
    }

    componentDidMount() {
        this.fetchOptions()
    }

    handleChange = (event) => {
        const target = event.target;
        const value  = target.type === 'checkbox' ? target.checked : target.value;
        const name   = target.name;
        this.setState({ [name]: value });
    }

    handleScriptsChange = (selectedOption) => {
        this.setState({ scripts: selectedOption });
    }

    handleStylesChange = (selectedOption) => {
        this.setState({ styles: selectedOption });
    }

    handleSave = async () => {
        const URL = deepSettings.url + 'deep-performance/settings?settings'
        const config = {
            headers: {
                'X-WP-Nonce': deepSettings.nonce,
                'Content-Type': 'application/json'
            }
        }
        await axios.post(URL, JSON.stringify(this.state), config)
        .then(function () {
            toast.success('Saved.', {
                duration: 2000,
                style: {
                    marginTop: 30
                }
            })
        })
        .catch(function () {
            toast.error('Settings couldn\'t save.', {
                duration: 2000,
                style: {
                    marginTop: 30
                }
            })
        })
    }

    reset = () => {
        const URL = deepSettings.url + 'deep-performance/settings?settings'
        const config = {
            headers: {
                'X-WP-Nonce': deepSettings.nonce,
                'Content-Type': 'application/json'
            }
        }

        confirm.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(URL, JSON.stringify([]), config)
                .then(function () {
                    window.location.reload()
                })
                .catch(function () { })
                confirm.fire(
                    'Reset successful!',
                )
            }
        })
    }

    render() {
        const options = this.state
        const reset = this.reset
        const handleSave = this.handleSave
        const handleChange = this.handleChange
        const handleScriptsChange = this.handleScriptsChange
        const handleStylesChange = this.handleStylesChange

        return (
            <OptionsContext.Provider value={{ options, reset, handleSave, handleChange, handleScriptsChange, handleStylesChange }}>
                {this.props.children}
            </OptionsContext.Provider>
        )
    }
}

export default OptionsContextProvider
