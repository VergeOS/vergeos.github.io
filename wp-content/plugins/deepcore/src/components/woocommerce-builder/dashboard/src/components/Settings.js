import { useContext } from "react";
import { OptionsContext } from "../contexts/OptionsContext";

const Settings = () => {
    const { options, onChange, loading } = useContext(OptionsContext);

    return (
        <React.Fragment>
            {(loading) ? <div className="deep-loading-spin-wrap"><div></div><div></div></div> :
            <div className="deep-woo-settings">
                <div className="dwh-actions dwh-actions-row">
                    Wishlist Page Slug (Pro)
                    <input
                        type="text"
                        name="wishlistslug"
                        placeholder="wishlist"
                        defaultValue={typeof options["general"] === 'object' && options["general"]["wishlistslug"] ? options["general"]["wishlistslug"] : ''}
                        onChange={onChange}
                        data-parent="general"
                    />
                </div>
                <div className="dwh-actions dwh-actions-row">
                    Thumbnail Image Width
                    <input
                        type="text"
                        name="thumbnail_image_width"
                        placeholder="300"
                        defaultValue={typeof options["general"] === 'object' && options["general"]["thumbnail_image_width"] ? options["general"]["thumbnail_image_width"] : ''}
                        onChange={onChange}
                        data-parent="general"
                    />
                </div>
                <div className="dwh-actions dwh-actions-row">
                    Single Image Width
                    <input
                        type="text"
                        name="woocommerce_single"
                        placeholder="300"
                        defaultValue={typeof options["general"] === 'object' && options["general"]["woocommerce_single"] ? options["general"]["woocommerce_single"] : ''}
                        onChange={onChange}
                        data-parent="general"
                    />
                </div>
                <div className="dwh-actions dwh-actions-row">
                    Single Gallery Thumbnail
                    <input
                        type="text"
                        name="woocommerce_gallery_thumbnail"
                        placeholder="300"
                        defaultValue={typeof options["general"] === 'object' && options["general"]["woocommerce_gallery_thumbnail"] ? options["general"]["woocommerce_gallery_thumbnail"] : ''}
                        onChange={onChange}
                        data-parent="general"
                    />
                </div>
            </div>}
        </React.Fragment>
    );
};

export default Settings;
