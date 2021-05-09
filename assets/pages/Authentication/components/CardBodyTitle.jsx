import React from "react";
import '../assets/css/CardBodyTitle.css';

export default function CardBodyTitle(props) {
    const {title, description} = props;

    return (
        <div className="mb-4 mt-3 text-center card-body-title-root">
            <div>
                <h4>{title}</h4>
            </div>
            {description}
        </div>
    );
}