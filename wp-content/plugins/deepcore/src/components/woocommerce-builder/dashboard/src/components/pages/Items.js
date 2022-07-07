import singleIcon from "../../assets/svg/single.svg";
import archiveIcon from "../../assets/svg/archive.svg";
import cartIcon from "../../assets/svg/cart.svg";
import checkoutIcon from "../../assets/svg/checkout.svg";
import compareIcon from "../../assets/svg/compare.svg";
import emptycartIcon from "../../assets/svg/empty-cart.svg";
import quickviewIcon from "../../assets/svg/quick-view.svg";
import shopIcon from "../../assets/svg/shop.svg";
import thankyouIcon from "../../assets/svg/thankyou.svg";
import wishlistIcon from "../../assets/svg/wishlist.svg";
import editIcon from "../../assets/svg/edit.svg";
import Remove from "../Remove";

const Page = (props) => {
    const title = props.page.title.rendered;
    const editURL =
        deepWooOptions.admin_url +
        "post.php?post=" +
        props.page.id +
        "&action=elementor";
    const name = title.replace(" ", "").toLowerCase();
    const pageType = props.page.meta.page_type[0];
    const customPage = props.page.meta.page_type[1];

    return (
        <div className="deep-woo-page-item">
            <div className="deep-woo-page-item-inner">
                {customPage && <Remove id={props.page.id} />}

                {Array.isArray(pageType) && pageType[0] === "wishlist" ? (
                    <img className="deep-woo-page-icon" src={wishlistIcon} />
                ) : (
                    ""
                )}
                { Array.isArray(pageType) && pageType[0] === "thankYou" ? (
                    <img className="deep-woo-page-icon" src={thankyouIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "shop" ? (
                    <img className="deep-woo-page-icon" src={shopIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "quickView" ? (
                    <img className="deep-woo-page-icon" src={quickviewIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "emptyCart" ? (
                    <img className="deep-woo-page-icon" src={emptycartIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "compare" ? (
                    <img className="deep-woo-page-icon" src={compareIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "checkout" ? (
                    <img className="deep-woo-page-icon" src={checkoutIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "cart" ? (
                    <img className="deep-woo-page-icon" src={cartIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "archive" ? (
                    <img className="deep-woo-page-icon" src={archiveIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "single" ? (
                    <img className="deep-woo-page-icon" src={singleIcon} />
                ) : (
                    ""
                )}
                <h3 className="deep-woo-page-name">{title}</h3>
                <div className="deep-woo-pages-actions">
                {Array.isArray(pageType) && pageType[0] === "single" ? (
                    <a href={editURL} target="_blank">
                        <div className="deep-woo-edit-page">
                            <img src={editIcon} />
                            Edit
                        </div>
                    </a>
                ) : (
                    <a href="https://webnus.net/deep-wordpress-theme/" target="_blank">
                        <div className="deep-woo-edit-page">
                            Pro
                        </div>
                    </a>
                )}
                </div>
                <div className="deep-woo-checkbox">
                    <input
                        type="checkbox"
                        name={name}
                        id={name}
                        data-parent={props.parent}
                        data-pagetype={Array.isArray(pageType) && pageType[0] ? pageType[0] : ''}
                        data-key={props.page.id}
                        defaultChecked={
                            Array.isArray(pageType) && props.state[pageType[0]] == props.page.id
                                ? true
                                : false
                        }
                        onClick={(e) => {
                            props.onChange(e);
                        }}
                        className="pr-checkbox"
                    />
                    <div>Activate</div>
                </div>
            </div>
        </div>
    );
};

export default Page;
