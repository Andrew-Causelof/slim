export default function Chat() {
    return (
        <main className="main main-full">
            <div className="content">
                <div className="content_head">
                    <div className="breadcrumbs">
                        <a
                            href="client.html"
                            className="breadcrumbs_link"
                        >Личный кабинет</a
                        >
                        <span className="breadcrumbs_sep">/</span>
                        <span className="breadcrumbs_text">Чат с клиникой</span>
                    </div>
                    <div className="title title-page">Чат с клиникой</div>
                </div>
                <div className="content_body">
                    <div className="chat">
                        <div className="chat_messages">
                            <div className="chat_message">
                                <div className="chat_message_profile">
                                    <div className="chat_message_profile_avatar"><span>О</span></div>
                                    <div className="chat_message_profile_name">Добронравов Олег Робертович</div>
                                </div>
                                <div className="chat_message_content">
                                    <div className="chat_message_actions">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <div className="message">
                                        Уточните пожалуйста, обязательно ли иметь при себе оригинал паспорта или
                                        достаточно будет сканированной копии?
                                    </div>
                                    <div className="chat_message_timestamp">
                                        <span>18:50</span>
                                        <span>22.12.2024</span>
                                    </div>
                                </div>
                            </div>
                            <div className="chat_message chat_message-reverse">
                                <div className="chat_message_profile">
                                    <div className="chat_message_profile_name">SL - Клиника</div>
                                    <div className="chat_message_profile_avatar"><span>SL</span></div>
                                </div>
                                <div className="chat_message_content">
                                    <div className="chat_message_actions">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <div className="message">
                                        Добрый день, Олег!<br />Спасибо за ваш вопрос. <br />Пить нельзя за 3 часа
                                        до операции. Строго натощак. <br />Оригинал пасорта можно с собой не брать.
                                    </div>
                                    <div className="chat_message_timestamp">
                                        <span>18:50</span>
                                        <span>22.12.2024</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form className="chat_form">
                            <input
                                className="chat_form_input"
                                name="chat"
                                id="chat-client"
                                placeholder="Написать сообщение"
                            />
                            <div className="chat_form_actions">
                                <div className="chat_form_file">
                                    <input
                                        type="file"
                                        id="chat-file"
                                    />
                                    <label htmlFor="chat-file"></label>
                                </div>
                                <button
                                    className="btn btn-main"
                                    type="submit"
                                >
                                    Отправить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    )
}
