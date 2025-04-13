// Заготовленные фейковые данные чата
export const mockMessages = [
  {
    id: 1,
    author: {
      name: "Добронравов Олег Робертович",
      initials: "О",
    },
    text: "Уточните пожалуйста, обязательно ли иметь при себе оригинал паспорта или достаточно будет сканированной копии?",
    timestamp: "18:50",
    date: "22.12.2024",
    isClinic: false,
    files: [],
  },
  {
    id: 2,
    author: {
      name: "SL - Клиника",
      initials: "SL",
    },
    text: "Добрый день, Олег!\nСпасибо за ваш вопрос.\nПить нельзя за 3 часа до операции. Строго натощак.\nОригинал паспорта можно с собой не брать.",
    timestamp: "18:50",
    date: "22.12.2024",
    isClinic: true,
    files: [],
  },
  {
    id: 3,
    author: {
      name: "Добронравов Олег Робертович",
      initials: "О",
    },
    text: "Вот файлы, о которых мы говорили.",
    timestamp: "19:50",
    date: "22.12.2024",
    isClinic: false,
    files: [
      {
        name: "Докумеsssssssssssssssssssssssssssssssssssssssssнт.pdf",
        url: "https://assuntamadre.ru/wp-content/uploads/2025/03/AM_menu_postnoe.pdf",
        type: "document",
      },
      {
        name: "Фото.png",
        url: "https://spinelife.ru/wp-content/uploads/2019/09/IMG_4722.jpg",
        type: "image",
      },
    ],
  },
];

// Функция-заглушка вместо fetch для тестов
export function mockFetchChatHistory() {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve(mockMessages);
    }, 500); // Имитируем сетевую задержку в 500 мс
  });
}
