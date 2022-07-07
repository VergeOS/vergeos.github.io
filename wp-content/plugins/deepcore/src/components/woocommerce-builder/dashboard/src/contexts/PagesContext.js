import { createContext, useState, useEffect } from "react";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";
import toast from "react-hot-toast";

const confirm = withReactContent(Swal);
const axios = require("axios");

export const PagesContext = createContext();

const PagesContextProvider = (props) => {
    const [pages, setPages] = useState([]);
    const [dashboardPages, setDashboardPages] = useState([]);
    const [loopPages, setLoopPages] = useState([]);

    const getPages = async () => {
        const pages = await fetchPages();
        setPages(pages);
    };

    useEffect(() => {
        getPages();
    }, []);

    const fetchPages = async () => {
        const pagesURL =
            deepWooOptions.url + "wp/v2/deep_woo_pages/?per_page=100";
        const res = await fetch(pagesURL, {
            headers: {
                "Content-Type": "application/json",
                "X-WP-Nonce": deepWooOptions.nonce,
            },
        });
        const data = await res.json();

        return data;
    };

    const getDashboardPages = async () => {
        const pages = await fetchDashboardPages();
        setDashboardPages(pages);
    };

    useEffect(() => {
        getDashboardPages();
    }, []);

    const fetchDashboardPages = async () => {
        const dashboardPagesURL =
            deepWooOptions.url + "wp/v2/deep_woo_dash_pages/?per_page=100";
        const res = await fetch(dashboardPagesURL, {
            headers: {
                "Content-Type": "application/json",
                "X-WP-Nonce": deepWooOptions.nonce,
            },
        });
        const data = await res.json();

        return data;
    };

    const getLoopPages = async () => {
        const pages = await fetchLoopPages();
        setLoopPages(pages);
    };

    useEffect(() => {
        getLoopPages();
    }, []);

    const fetchLoopPages = async () => {
        const dashboardPagesURL =
            deepWooOptions.url + "wp/v2/deep_woo_loop_pages/?per_page=100";
        const res = await fetch(dashboardPagesURL, {
            headers: {
                "Content-Type": "application/json",
                "X-WP-Nonce": deepWooOptions.nonce,
            },
        });
        const data = await res.json();

        return data;
    };

    const deletePage = (id) => {
        const URL = deepWooOptions.url + "deep-woo-dashboard/pages";
        const data = { action: "delete", ID: id };

        const config = {
            headers: {
                "X-WP-Nonce": deepWooOptions.nonce,
                "Content-Type": "application/json",
            },
        };

        confirm
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post(URL, JSON.stringify(data), config)
                        .then(function () {
                            update();
                        })
                        .catch(function () {});
                    confirm.fire("Deleted successful!");
                }
            });
    };

    const update = () => {
        getPages();
        getDashboardPages();
        getLoopPages();
    };

    const AddNew = (name, option, type) => {
        const data = {
            action: "create",
            name: name,
            option: option,
            type: type,
        };

        const URL = deepWooOptions.url + "deep-woo-dashboard/pages";
        const config = {
            headers: {
                "X-WP-Nonce": deepWooOptions.nonce,
                "Content-Type": "application/json",
            },
        };
        axios
            .post(URL, JSON.stringify(data), config)
            .then(function () {
                toast.success("Added successfully.", {
                    duration: 2000,
                    style: {
                        marginTop: 30,
                    },
                });

                update();
            })
            .catch(function () {
                toast.error("Couldn't add.", {
                    duration: 2000,
                    style: {
                        marginTop: 30,
                    },
                });
            });
    };

    return (
        <PagesContext.Provider
            value={{
                pages,
                dashboardPages,
                loopPages,
                update,
                deletePage,
                AddNew,
            }}
        >
            {props.children}
        </PagesContext.Provider>
    );
};

export default PagesContextProvider;
