import Header from './components/Header.jsx';
import AsideMenu from './components/AsideMenu.jsx';
import MainContent from './components/MainContent.jsx';
import Messengers from './components/Messengers.jsx';
import { useDataLoader } from './useDataLoader.js';
import { NotificationProvider } from './context/NotificationContext.jsx';

import { useUserStore } from './store';

function App() {
  // Загружаем данные один раз при инициализации
  useDataLoader();

  const { userData } = useUserStore();

  return (
    <NotificationProvider>
      <div className="page page-client">
        <div className="layout">
          <Header />
          <AsideMenu />
          <MainContent />
        </div>
        {userData.activeTab !== 'chat' &&  <Messengers />}
      </div>
    </NotificationProvider>

  );
}

export default App;