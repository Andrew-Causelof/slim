//@TODO нужн обудет реализовать загрузку данных при инициализации
import { useEffect } from "react";
import { useUserStore } from "./store";

function useDataLoader() {
  const fetchUserData = useUserStore((state) => state.fetchUserData);
  const setUserId = useUserStore((state) => state.setUserId);

  useEffect(() => {
    const userId = window.__USER__.userID;
    setUserId(userId);  
    fetchUserData(userId);
  }, [fetchUserData]); // Запуск загрузки при монтировании
}

export { useDataLoader };
