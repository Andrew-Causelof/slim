import { useUserStore } from '../store';

export default function Messengers() {

    const { userData, setUserData } = useUserStore();

    return (
        <div className="messengers" onClick={() => setUserData('activeTab', 'chat')}>
            <div className="messengers_trigger">
                <span className="messengers_icon"></span>
            </div>
            <div className="messengers_items"></div>
        </div>
    )

}
