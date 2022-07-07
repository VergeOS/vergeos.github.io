import editIcon from "../../assets/svg/edit.svg";
import recentIcon from "../../assets/svg/recent.svg";
import relatedIcon from "../../assets/svg/related.svg";
import upsellIcon from "../../assets/svg/upsell.svg";
import crossSellIcon from "../../assets/svg/cross-sell.svg";
import featuredIcon from "../../assets/svg/featured.svg";
import bestsellingIcon from "../../assets/svg/bestselling.svg";
import topratedIcon from "../../assets/svg/toprated.svg";
import saleIcon from "../../assets/svg/sale.svg";
import Remove from "../Remove";

const Page = (props) => {
    const title = props.page.title.rendered
    const editURL =
        deepWooOptions.admin_url +
        "post.php?post=" +
        props.page.id +
        "&action=elementor";
    const pageType = props.page.meta.page_type[0];
    const customPage = props.page.meta.page_type[1];

    return (
        <>
            <div className="deep-woo-page-item">
                <div className="deep-woo-page-item-inner">
                    {customPage && <Remove id={props.page.id} />}

                    {pageType[0] === "recentProducts" ? (
                        <img className="deep-woo-page-icon" src={recentIcon} />
                    ) : (
                        ""
                    )}
                    {pageType[0] === "relatedProducts" ? (
                        <img className="deep-woo-page-icon" src={relatedIcon} />
                    ) : (
                        ""
                    )}
                    {pageType[0] === "upSellProducts" ? (
                        <img className="deep-woo-page-icon" src={upsellIcon} />
                    ) : (
                        ""
                    )}
                    {pageType[0] === "crossSellProducts" ? (
                        <img
                            className="deep-woo-page-icon"
                            src={crossSellIcon}
                        />
                    ) : (
                        ""
                    )}
                    {pageType[0] === "featuredProducts" ? (
                        <img
                            className="deep-woo-page-icon"
                            src={featuredIcon}
                        />
                    ) : (
                        ""
                    )}
                    {pageType[0] === "bestSellingProducts" ? (
                        <img
                            className="deep-woo-page-icon"
                            src={bestsellingIcon}
                        />
                    ) : (
                        ""
                    )}
                    {pageType[0] === "topRatedProducts" ? (
                        <img
                            className="deep-woo-page-icon"
                            src={topratedIcon}
                        />
                    ) : (
                        ""
                    )}
                    {pageType[0] === "saleProducts" ? (
                        <img className="deep-woo-page-icon" src={saleIcon} />
                    ) : (
                        ""
                    )}
                    <h3 className="deep-woo-page-name">{title}</h3>
                    <div className="deep-woo-pages-actions">
                        {pageType[0] === "recentProducts" || pageType[0] === "relatedProducts" ? (
                            <a href={editURL} target="_blank">
                                <div className="deep-woo-edit-page">
                                    <img src={editIcon} />
                                    Edit
                                </div>
                            </a>
                        ) : (
                            <div className="deep-woo-edit-page">
                                <a href="https://webnus.net/deep-wordpress-theme/" target="_blank">Pro</a>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </>
    );
};

export default Page;
