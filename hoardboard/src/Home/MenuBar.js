// install extension ES7
// type rfce
import React from 'react';
import './MenuBar.css';
import Logo from './Logo';
import MenuIcon from '@material-ui/icons/Menu';
import VideoCallIcon from '@material-ui/icons/VideoCall';
import AppsIcon from '@material-ui/icons/Apps';
import NotificationsIcon from '@material-ui/icons/Notifications';

function MenuBar() {
    return (
        <div className="menubar">
            {/*Website Logo container */}
            <div className="logo__container">
                <Logo />
            </div> 

            {/* User Bar container */}
            <div className="menu__icons">
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
