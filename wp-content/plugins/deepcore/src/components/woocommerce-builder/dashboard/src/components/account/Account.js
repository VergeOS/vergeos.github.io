import { useContext } from "react";
import { PagesContext } from "../../contexts/PagesContext";
import { OptionsContext } from "../../contexts/OptionsContext";
import Page from "./Items";

const Account = () => {
    const { dashboardPages } = useContext(PagesContext);
    const { options, onChange, loading } = useContext(OptionsContext);

    return (
        <React.Fragment>
            {(loading) ? <div className="deep-loading-spin-wrap"><div></div><div></div></div> :
            <div>
                {options["dashboard_pages"] &&
                dashboardPages.map((page) => (
                    <Page
                        key={page.id}
                        page={page}
                        onChange={onChange}
                        state={options["dashboard_pages"]}
                        parent="dashboard_pages"
                    />
                ))}
            </div>}
        </React.Fragment>
    );
};

export default Account;
