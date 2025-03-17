import About from "./MainContent/About";
import Chat from "./MainContent/Chat";
import Docs from "./MainContent/Docs";
import Info from "./MainContent/Info";
import Recomendation from "./MainContent/Recomendation";
import Rules from "./MainContent/Rules";
import { useUserStore } from "../store";

export default function MainContent() {
    const { userData } = useUserStore();

    console.log(userData)

    return (
        <>
            {userData.activeTab === 'about' && <About />}
            {userData.activeTab === 'info' && <Info />}
            {userData.activeTab === 'docs' && <Docs />}
            {userData.activeTab === 'rules' && <Rules />}
            {userData.activeTab === 'recomendation' && <Recomendation />}
            {userData.activeTab === 'chat' && <Chat />}
        </>
    );
}
