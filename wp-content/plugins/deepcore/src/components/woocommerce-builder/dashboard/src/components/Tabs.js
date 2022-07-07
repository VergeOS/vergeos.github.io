import PagesContextProvider from '../contexts/PagesContext'
import OptionsContextProvider from '../contexts/OptionsContext'
import Pages from './pages/Pages'
import Account from './account/Account'
import ProductsLoop from './loop/Loop'
import Header from './Header'
import Settings from './Settings'
import ImportExport from './ImportExport'
import { Toaster } from 'react-hot-toast'
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs'
import 'react-tabs/style/react-tabs.css'

const WooTabs = () => {
    return (
        <OptionsContextProvider>
            <PagesContextProvider>
                <Header/>
                <Tabs>
                    <div className="deep-woo-dashboard-tabs-items">
                        <div className="woo-pages-menu-title">WooCommerce</div>
                        <TabList>
                            <Tab>Woo Pages</Tab>
                            <Tab>Dashboard Pages</Tab>
                            <Tab>Product Loop</Tab>
                            <Tab>Settings</Tab>
                            <Tab>Import / Export</Tab>
                        </TabList>
                        <Toaster />
                    </div>
                    <div className="deep-woo-dashboard-tabs">
                        <TabPanel>
                            <Pages />
                        </TabPanel>
                        <TabPanel>
                            <Account />
                        </TabPanel>
                        <TabPanel>
                            <ProductsLoop />
                        </TabPanel>
                        <TabPanel>
                            <Settings />
                        </TabPanel>
                        <TabPanel>
                            <ImportExport />
                        </TabPanel>
                    </div>
                </Tabs>
            </PagesContextProvider>
        </OptionsContextProvider>
    )
}

export default WooTabs
