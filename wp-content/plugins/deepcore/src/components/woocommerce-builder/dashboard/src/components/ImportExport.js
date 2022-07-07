import { useState } from 'react'
import toast from 'react-hot-toast'
import Swal from 'sweetalert2'
import withReactContent from 'sweetalert2-react-content'

const confirm = withReactContent(Swal)
const axios = require('axios')

const ImportExport = () => {
    const [optionsFile, setOptionsFile] = useState();
    const [pagesFile, setPagesFile] = useState();
    const [dashboardFile, setDashboardFile] = useState();
    const [loopFile, setLoopFile] = useState();

    let fileReader;
    const URL = deepWooOptions.url + 'deep-woo-dashboard/export'

    const exportData = (type) => {
        const date = new Date();
        const dateFormat = date.getDate() + "-" + (date.getMonth()+1) + "-" + date.getFullYear()

        const config = {
            headers: {
                'X-WP-Nonce': deepWooOptions.nonce,
            }
        }

        axios.post(URL, { action: type }, config )
        .then(function (res) {

            if ( type === 'exportOptions' ) {
                const data = JSON.stringify(res.data)
                download(`deep-woo-builder-options-${dateFormat}.json`, data)
            }

            if ( type === 'exportPages' ) {
                const data = res.data;
                download(`deep-woo-builder-pages-${dateFormat}.xml`, data)
            }

            if ( type === 'exportDashboard' ) {
                const data = res.data;
                download(`deep-woo-builder-dashboard-${dateFormat}.xml`, data)
            }

            if ( type === 'exportLoop' ) {
                const data = res.data;
                download(`deep-woo-builder-loop-${dateFormat}.xml`, data)
            }

            toast.success('Export successful.', {
                duration: 2000,
                style: {
                    marginTop: 30
                }
            })
        })
        .catch(function () {
            toast.error('Couldn\'t Export.', {
                duration: 2000,
                style: {
                    marginTop: 30
                }
            })
        })
    }

    const importOptions = (e) => {
        e.preventDefault()

        const config = {
            headers: {
                'X-WP-Nonce': deepWooOptions.nonce,
            }
        }

        const formData = new FormData();
        formData.append('importOptions', {filename: importOptions});

        const form = { action: 'importOptions', importOptions: optionsFile }

        axios.post(URL, form, config )
        .then(function () {
            toast.success('Import successful.', {
                duration: 2000,
                style: {
                    marginTop: 30
                }
            })
            window.location.reload()
        })
        .catch(function () {
            toast.error('Couldn\'t Import.', {
                duration: 2000,
                style: {
                    marginTop: 30
                }
            })
        })
    }

    const importPages = (e) => {
        e.preventDefault()

        const config = {
            headers: {
                'X-WP-Nonce': deepWooOptions.nonce,
            }
        }

        const formData = new FormData();
        formData.append('importPages', {filename: importPages});

        const form = { action: 'importPages', importPages: pagesFile }

        confirm.fire({
            title: 'Are you sure?',
            text: 'The current pages will be deleted',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Import'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(URL, form, config )
                .then(function () {
                    toast.success('Import successful.', {
                        duration: 2000,
                        style: {
                            marginTop: 30
                        }
                    })
                    window.location.reload()
                })
                .catch(function () {
                    toast.error('Couldn\'t Import.', {
                        duration: 2000,
                        style: {
                            marginTop: 30
                        }
                    })
                })
            }
        })
    }

    const importDashboardPages = (e) => {
        e.preventDefault()

        const config = {
            headers: {
                'X-WP-Nonce': deepWooOptions.nonce,
            }
        }

        const formData = new FormData();
        formData.append('importDashboardPages', {filename: importDashboardPages});

        const form = { action: 'importDashboardPages', importDashboardPages: dashboardFile }

        confirm.fire({
            title: 'Are you sure?',
            text: 'The current pages will be deleted',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Import'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(URL, form, config )
                .then(function () {
                    toast.success('Import successful.', {
                        duration: 2000,
                        style: {
                            marginTop: 30
                        }
                    })
                    window.location.reload()
                })
                .catch(function () {
                    toast.error('Couldn\'t Import.', {
                        duration: 2000,
                        style: {
                            marginTop: 30
                        }
                    })
                })
            }
        })
    }

    const importLoopPages = (e) => {
        e.preventDefault()

        const config = {
            headers: {
                'X-WP-Nonce': deepWooOptions.nonce,
            }
        }

        const formData = new FormData();
        formData.append('importLoopPages', {filename: importLoopPages});

        const form = { action: 'importLoopPages', importLoopPages: loopFile }

        confirm.fire({
            title: 'Are you sure?',
            text: 'The current pages will be deleted',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Import'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post(URL, form, config )
                .then(function () {
                    toast.success('Import successful.', {
                        duration: 2000,
                        style: {
                            marginTop: 30
                        }
                    })
                    window.location.reload()
                })
                .catch(function () {
                    toast.error('Couldn\'t Import.', {
                        duration: 2000,
                        style: {
                            marginTop: 30
                        }
                    })
                })
            }
        })
    }

    const handleOptionsRead = () => {
        const content = fileReader.result;
        setOptionsFile(content)
    };

    const handlePagesRead = () => {
        const content = fileReader.result;
        setPagesFile(content)
    };

    const handleDashboardRead = () => {
        const content = fileReader.result;
        setDashboardFile(content)
    };

    const handleLoopRead = () => {
        const content = fileReader.result;
        setLoopFile(content)
    };

    const handleOptionsChosen = (file) => {
        fileReader = new FileReader();
        fileReader.onloadend = handleOptionsRead;
        fileReader.readAsText(file);
    };

    const handlePagesChosen = (file) => {
        fileReader = new FileReader();
        fileReader.onloadend = handlePagesRead;
        fileReader.readAsText(file);
    };

    const handleDashboardChosen = (file) => {
        fileReader = new FileReader();
        fileReader.onloadend = handleDashboardRead;
        fileReader.readAsText(file);
    };

    const handleLoopChosen = (file) => {
        fileReader = new FileReader();
        fileReader.onloadend = handleLoopRead;
        fileReader.readAsText(file);
    };

    const download = (filename, content) => {
        let link = document.createElement('a')
        link.setAttribute('href', 'data:text/plaincharset=utf-8,' + encodeURIComponent(content))
        link.setAttribute('download', filename)
        link.style.display = 'none'
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
    }

    return (
        <>
            <div className='dwh-actions dwh-actions-row'>
                <h4 className='deep-woo-page-name'>Options</h4>
                <div className='dwh-actions' style={{ marginBottom: 20 }}>
                    <button className='dwh-btn-type2' onClick={() => exportData('exportOptions')}>Export Options</button>
                </div>
                <form onSubmit={importOptions}>
                    <input type='file' name='importOptions' accept='.json' style={{ marginBottom: 10 }} onChange={e => handleOptionsChosen(e.target.files[0])}/>
                    <div>
                        <button type='submit' className='dwh-btn-type2'>Import Options</button>
                    </div>
                </form>
            </div>

            <div className='dwh-actions dwh-actions-row'>
                <h4 className='deep-woo-page-name'>Woo Pages</h4>
                <div className='dwh-actions' style={{ marginBottom: 20 }}>
                    <button className='dwh-btn-type2' onClick={() => exportData('exportPages')}>Export Woo Pages</button>
                </div>
                <form onSubmit={importPages}>
                    <input type='file' name='importPages' accept='.xml' style={{ marginBottom: 10 }} onChange={e => handlePagesChosen(e.target.files[0])}/>
                    <div>
                        <button type='submit' className='dwh-btn-type2'>Import Woo Pages</button>
                    </div>
                </form>
            </div>

            <div className='dwh-actions dwh-actions-row'>
                <h4 className='deep-woo-page-name'>Dashboard Pages</h4>
                <div className='dwh-actions' style={{ marginBottom: 20 }}>
                    <button className='dwh-btn-type2' onClick={() => exportData('exportDashboard')}>Export Dashboard Pages</button>
                </div>
                <form onSubmit={importDashboardPages}>
                    <input type='file' name='importDashboardPages' accept='.xml' style={{ marginBottom: 10 }} onChange={e => handleDashboardChosen(e.target.files[0])}/>
                    <div>
                        <button type='submit' className='dwh-btn-type2'>Import Dashboard Pages</button>
                    </div>
                </form>
            </div>

            <div className='dwh-actions dwh-actions-row'>
                <h4 className='deep-woo-page-name'>Products Loop</h4>
                <div className='dwh-actions' style={{ marginBottom: 20 }}>
                    <button className='dwh-btn-type2' onClick={() => exportData('exportLoop')}>Export Products Loop</button>
                </div>
                <form onSubmit={importLoopPages}>
                    <input type='file' name='importLoopPages' accept='.xml' style={{ marginBottom: 10 }} onChange={e => handleLoopChosen(e.target.files[0])}/>
                    <div>
                        <button type='submit' className='dwh-btn-type2'>Import Products Loop</button>
                    </div>
                </form>
            </div>
        </>
    )
}

export default ImportExport
