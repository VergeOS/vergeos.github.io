import { createContext, useState, useEffect } from "react";
import toast from "react-hot-toast";
import Swal from "sweetalert2";
import withReactContent from "sweetalert2-react-content";

const axios = require("axios");
const confirm = withReactContent(Swal);

export const OptionsContext = createContext();

NProgress.configure({
    barSelector: '[role="bar"]',
    parent: '.react-tabs',
});

const OptionsContextProvider = (props) => {
    const [options, setOptions] = useState([]);
    const [loading, setLoading] = useState(false);

    const getOptions = async () => {
        const options = await fetchOptions();
        setOptions(options);
    };

    useEffect(() => {
        getOptions();
    }, []);

    const fetchOptions = async () => {
        NProgress.start();
        setLoading(true)
        const URL = deepWooOptions.url + "deep-woo-dashboard/options";
        const response = await fetch(URL, {
            headers: {
                "X-WP-Nonce": deepWooOptions.nonce,
            },
        });
        if (response.ok) {
            NProgress.done(true);
            setLoading(false)
        }
        const data = await response.json();
        return JSON.parse(data);
    };

    const onChange = (event) => {
        const target = event.target;
        const parent = target.getAttribute("data-parent");
        const name = target.name;
        if (target.type === "checkbox") {
            const checked = target.checked;
            const pageType = target.getAttribute("data-pagetype");
            const key = target.getAttribute("data-key");
            const data = '[data-pagetype="' + pageType + '"]';
            var allElements = document.querySelectorAll(data);
            var i;
            for (i = 0; i < allElements.length; i++) {
                allElements[i].checked = false;
            }
            if (checked) {
                target.checked = true;
                options[parent][pageType] = key;
            } else {
                options[parent][pageType] = "";
                target.checked = false;
            }
            console.log(options[parent]);
        }

        if (target.type === "text") {
            const value = target.value;
            options[parent][name] = value;
            console.log(options[parent]);
        }

        setOptions(options);
    };

    const handleSave = async () => {
        NProgress.start();
        setLoading(true)
        const URL =
            (await deepWooOptions.url) + "deep-woo-dashboard/options?options";
        const config = {
            headers: {
                "X-WP-Nonce": deepWooOptions.nonce,
                "Content-Type": "application/json",
            },
        };
        await axios
            .post(URL, JSON.stringify(options), config)
            .then(function () {
                console.log(options);
                NProgress.done(true);
                setLoading(false)
                toast.success("Saved.", {
                    duration: 2000,
                    style: {
                        marginTop: 30,
                    },
                });
            })
            .catch(function () {
                NProgress.done(true);
                setLoading(false)
                toast.error("Settings couldn't save.", {
                    duration: 2000,
                    style: {
                        marginTop: 30,
                    },
                });
            });
    };

    const reset = () => {
        const URL = deepWooOptions.url + "deep-woo-dashboard/options?options";
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
                confirmButtonText: "Yes, reset it!",
            })
            .then((result) => {
                if (result.isConfirmed) {
                    axios
                        .post(URL, JSON.stringify([]), config)
                        .then(function () {
                            window.location.reload();
                        })
                        .catch(function () {});
                    confirm.fire("Reset successful!");
                }
            });
    };

    return (
        <OptionsContext.Provider
            value={{ options, loading, onChange, handleSave, reset }}
        >
            {props.children}
        </OptionsContext.Provider>
    );
};

export default OptionsContextProvider;
