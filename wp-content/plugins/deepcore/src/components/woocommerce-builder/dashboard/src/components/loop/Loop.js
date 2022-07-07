import { useContext } from "react";
import { PagesContext } from "../../contexts/PagesContext";
import { OptionsContext } from "../../contexts/OptionsContext";
import Loop from "./Items";

const Pages = () => {
    const { loopPages } = useContext(PagesContext);
    const { options, onChange, loading } = useContext(OptionsContext);

    return (
        <React.Fragment>
            {(loading) ? <div className="deep-loading-spin-wrap"><div></div><div></div></div> :
            <div>
                {loopPages &&
                loopPages.map((page) => (
                    <Loop
                        key={page.id}
                        page={page}
                        onChange={onChange}
                        state={options["product_loop"]}
                        parent="product_loop"
                    />
                ))}
            </div>}
        </React.Fragment>
    );
};

export default Pages;
