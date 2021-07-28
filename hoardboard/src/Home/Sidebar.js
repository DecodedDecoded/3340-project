import React from 'react';
import './Sidebar.css';
import SearchIcon from '@material-ui/icons/Search';

function Sidebar() {
    return (
        <div className="sidebar">
            {/* Search Bar container */}
            <div className="search__bar">
                <input type="text" placeholder="Search"/>

                <SearchIcon className="search__button"/>
            </div>
        </div>
    )
}

export default Sidebar;