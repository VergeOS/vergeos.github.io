import { useContext } from "react";
import { PagesContext } from "../../contexts/PagesContext";
import { OptionsContext } from "../../contexts/OptionsContext";
import Page from "./Items";

const Pages = () => {
    const { pages } = useContext(PagesContext);
    const { options, onChange,loading } = useContext(OptionsContext);

    return (
        <React.Fragment>
            {(loading) ? <div className="deep-loading-spin-wrap"><div></div><div></div></div> :
            <div>
                {options["woo_pages"] &&
                pages.map((page) => (
                    <Page
                        key={page.id}
                        page={page}
                        onChange={onChange}
                        state={options["woo_pages"]}
                        parent="woo_pages"
                    />
                ))}
            </div>}
        </React.Fragment>
    );
};

export default Pages;
