import React from 'react';
import './Logo.css';

function Logo() {
    return (
        <div className="Logo">
            {/*Website Logo */}
            <img 
                className="header__logo"
                src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Logo_of_YouTube_%282015-2017%29.svg"
                alt=""
            />
        </div>
    )
}

export default Logo;
