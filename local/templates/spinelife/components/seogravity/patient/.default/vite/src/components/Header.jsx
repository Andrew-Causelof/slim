import React from 'react';
import { useUserStore } from '../store';

function Header() {

    const { userData, setUserData } = useUserStore();

    return (
        <header className="header gradient">
            <a className="logo header_logo" onClick={() => setUserData('activeTab', 'about')}>
                <div className="logo_img">
                    <img src="/assets/img/svg/logo.svg" alt="Logo" />
                </div>
                <div className="logo_text">
                    <span className="logo_text_top">SL - Клиника</span>
                    <span className="logo_text_bottom">
                        Клиника консервативного лечения заболеваний позвоночника и суставов
                    </span>
                </div>
            </a>
            <div className="profile header_profile" tabIndex="0">
                <div className="profile_text">{`${userData.lastname} ${userData.firstname} ${userData.thirdname}`}</div>
                <div className="profile_avatar">
                    <span>О</span>
                </div>
            </div>
            <div className="burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </header>
    );
}

export default Header;
