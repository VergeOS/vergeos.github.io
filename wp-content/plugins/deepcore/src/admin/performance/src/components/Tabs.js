import OptionsContextProvider from '../context/OptionsContext'
import { Toaster } from 'react-hot-toast'
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs'
import Header from './Header'
import Elementor from './Elementor'
import WordPress from './WordPress'
import Optimization from './Optimization'
import Assets from './Assets'
import Cache from './Cache'
import 'react-tabs/style/react-tabs.css'
import '../index.css'

const PrTabs = () =>  {
    return (
        <OptionsContextProvider>
            <Header />
            <Tabs>
                <div className="deep-performance-tabs-items">
                    <div className="performance-pages-menu-title">Performance</div>
                    <TabList>
                        <Tab>Elementor</Tab>
                        <Tab>WordPress</Tab>
                        <Tab>Optimization</Tab>
                        <Tab>Assets Manager</Tab>
                        <Tab>Cache</Tab>
                    </TabList>
                    <Toaster />
                </div>
                <div className="deep-performance-tabs">
                    <TabPanel>
                        <Elementor />
                    </TabPanel>
                    <TabPanel>
                        <WordPress />
                    </TabPanel>
                    <TabPanel>
                        <Optimization />
                    </TabPanel>
                    <TabPanel>
                        <Assets />
                    </TabPanel>
                    <TabPanel>
                        <Cache />
                    </TabPanel>
                </div>
            </Tabs>
        </OptionsContextProvider>
    )
}

export default PrTabs
