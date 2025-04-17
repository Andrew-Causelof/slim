import About from "./MainContent/About";
import Chat from "./MainContent/Chat";
import Docs from "./MainContent/Docs";
import Info from "./MainContent/Info";
import Recomendation from "./MainContent/Recomendation";
import Rules from "./MainContent/Rules";
import { useUserStore } from "../store";
import Contacts from "./MainContent/Contacts";
import Preparing from "./MainContent/Preparing";
import Operation from "./MainContent/Operation";

export default function MainContent() {
    const { userData } = useUserStore();

    return (
        <>
            {userData.activeTab === 'rules' && <Rules />}
            {userData.activeTab === 'about' && <About />}
            {userData.activeTab === 'info' && <Info />}
            {userData.activeTab === 'docs' && <Docs />}
            {userData.activeTab === 'recomendation' && <Recomendation />}
            {userData.activeTab === 'chat' && <Chat />}
            {userData.activeTab === 'preparing' && <Preparing />}
            {userData.activeTab === 'operation' && <Operation />}
            {userData.activeTab === 'contacts' && <Contacts />}
            
        </>
    );
}
