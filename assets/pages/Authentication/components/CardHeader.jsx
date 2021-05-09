import React from "react";
import background from "../assets/background.jpeg";

export default function CardHeader() {
    return (
        <div className="card-header-background-color">
            <div className="row">
                <img src={background}
                     className='card-header-background'
                     alt="Page background"/>
            </div>
        </div>
    );
}