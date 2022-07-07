import editIcon from "../../assets/svg/edit.svg";
import accountIcon from "../../assets/svg/account.svg";
import addressesIcon from "../../assets/svg/addresses.svg";
import dashboardIcon from "../../assets/svg/dashboard.svg";
import downloadIcon from "../../assets/svg/download.svg";
import myaccountIcon from "../../assets/svg/myaccount.svg";
import ordersIcon from "../../assets/svg/orders.svg";
import Remove from "../Remove";

const Page = (props) => {
    const title = props.page.title.rendered
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

                {Array.isArray(pageType) && pageType[0] === "myAccount" ? (
                    <img className="deep-woo-page-icon" src={myaccountIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "addresses" ? (
                    <img className="deep-woo-page-icon" src={addressesIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "dashboard" ? (
                    <img className="deep-woo-page-icon" src={dashboardIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "downloads" ? (
                    <img className="deep-woo-page-icon" src={downloadIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "accountDetails" ? (
                    <img className="deep-woo-page-icon" src={accountIcon} />
                ) : (
                    ""
                )}
                {Array.isArray(pageType) && pageType[0] === "orders" ? (
                    <img className="deep-woo-page-icon" src={ordersIcon} />
                ) : (
                    ""
                )}
                <h3 className="deep-woo-page-name">{title}</h3>
                <div className="deep-woo-pages-actions">
                {Array.isArray(pageType) && pageType[0] === "myAccount" ? (
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
