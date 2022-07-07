import { useContext } from "react";
import { PagesContext } from "../contexts/PagesContext";

const Remove = ({ id }) => {
    const { deletePage } = useContext(PagesContext);

    const removePage = () => {
        deletePage(id)
    }

    return (
        <button className='deep-woo-remove-page' onClick={removePage}></button>
    )
}

export default Remove
