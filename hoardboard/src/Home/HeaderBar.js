import React from 'react';
import './HeaderBar.css';
import SearchIcon from '@material-ui/icons/Search';
import Avatar from '@material-ui/core/Avatar';

function HeaderBar() {
    return (
        <div className="headerbar">
            {/* Search Bar container */}
            <div className="searchbar__container">
                <input type="text" placeholder="Search"/>

                <SearchIcon className="search__button"/>
            </div>

            {/* User Profile Pic Avatar */}
            <div className="user__bar">
                <Avatar
                    className="avatar"
                    src="https://scontent.fybz2-1.fna.fbcdn.net/v/t1.6435-9/117771761_1557373284465363_7300586686690174496_n.jpg?_nc_cat=109&ccb=1-3&_nc_sid=09cbfe&_nc_ohc=Uh-XjyFjLH4AX8vPDzb&_nc_ht=scontent.fybz2-1.fna&oh=f53a63a60bcbd2d7cd17b21a3bbe6428&oe=60FA7040"
                    alt="Dariq A."
                />
            </div>
        </div>
    )
}

export default HeaderBar;