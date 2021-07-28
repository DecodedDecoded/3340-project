// install extension ES7
// type rfce
import React from 'react';
import './MenuBar.css';
import Logo from './Logo';
import MenuIcon from '@material-ui/icons/Menu';
import VideoCallIcon from '@material-ui/icons/VideoCall';
import AppsIcon from '@material-ui/icons/Apps';
import NotificationsIcon from '@material-ui/icons/Notifications';
import Avatar from '@material-ui/core/Avatar';

function MenuBar() {
    return (
        <div className="header">
            {/*Website Logo container */}
            <div className="logo__container">
                <Logo />
            </div> 

            {/* User Bar container */}
            <div className="user__bar">
                {/* User Profile Pic Avatar */}
                <Avatar
                    className="avatar"
                    src="https://scontent.fybz2-1.fna.fbcdn.net/v/t1.6435-9/117771761_1557373284465363_7300586686690174496_n.jpg?_nc_cat=109&ccb=1-3&_nc_sid=09cbfe&_nc_ohc=Uh-XjyFjLH4AX8vPDzb&_nc_ht=scontent.fybz2-1.fna&oh=f53a63a60bcbd2d7cd17b21a3bbe6428&oe=60FA7040"
                    alt="Dariq A."
                />

                {/* Menu Icon */}
                <MenuIcon />
                {/* User Icons */}
                <VideoCallIcon className="user__icon"/>
                <AppsIcon className="user__icon"/>
                <NotificationsIcon className="user__icon"/>
            </div>
        </div>
    )
}

export default MenuBar;
