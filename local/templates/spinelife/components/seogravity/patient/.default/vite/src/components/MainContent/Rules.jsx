import React from 'react'
import Breadcrumbs from '../common/Breadcrumbs';
import AsideInfo from '../common/AsideInfo'

export default function Rules() {
    return (
        <main className="main">
            <div className="content">
                <div className="content_head">
                    <Breadcrumbs current='Правила при госпитализации' />
                    <div className="title title-page">Правила при госпитализации</div>
                </div>
                <div className="content_body">

                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Общие требования</div>
                        </div>
                        <div className="article_body">
                            <div className="text_items">
                                <div className="text_item">
                                    <span className="text_item_count">1</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b>Обязательное выполнение всех пунктов перед госпитализацией.</b><br />
                                        </p>
                                        В случае отсутствия каких-либо документов из перечня, госпитализация
                                        невозможна.
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">2</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b>Сроки годности анализов и обследований строго соблюдайте</b> (указаны в
                                            скобках).
                                        </p>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">3</span>
                                    <div className="text_item_content">
                                        <p className="text_item_p">
                                            <b>Все результаты анализов и обследований должны содержать:</b>
                                        </p>
                                        <ul className="list">
                                            <li>МНО (международное нормализованное отношение)</li>
                                            <li>АЧТВ (активированное частичное тромбопластиновое время)</li>
                                            <li>Фибриноген</li>
                                            <li>Протромбиновое время</li>
                                            <li>Тромбиновое время</li>
                                            <li>Д-димер</li>
                                        </ul>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">4</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b>Отменить за 7 дней до операции:</b> Кардиомагнил, ТромбоАСС, аспирины,
                                            Клопидогрел.
                                        </p>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">5</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b>Отменить за 48 часов до операции: </b>Метформин (торговые названия:
                                            Глюкофаж), антикоагулянты (Клексан и другие).
                                        </p>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">6</span>
                                    <div className="text_item_content">
                                        <p><b>Отменить за 24 часа до операции: </b>Ксарелто, Эликвис, Прадакса.</p>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">7</span>
                                    <div className="text_item_content">
                                        <p><b>В день операции быть натощак </b>(не есть, не пить)</p>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">8</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b>Препараты для снижения давления принять в 6 часов утра, </b>запив
                                            минимальным количеством воды.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Порядок действий при госпитализации</div>
                        </div>
                        <div className="article_body">
                            <div className="text_items">
                                <div className="text_item">
                                    <span className="text_item_count">1</span>
                                    <div className="text_item_content">
                                        <p className="text_item_p">
                                            <b>Подготовка документов:</b>
                                        </p>
                                        <ul className="list">
                                            <li>Паспорт, полис ОМС, СНИЛС.</li>
                                            <li>
                                                Выписка из единого реестра застрахованных лиц (получить в МФЦ или на
                                                госуслугах).
                                            </li>
                                            <li>
                                                Направление 057у, оформленное в бюджетной поликлинике по месту
                                                прикрепления (должно соответствовать полису ОМС).
                                            </li>
                                            <li>
                                                Оригиналы всех анализов и обследований с печатями и подписями врачей.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">2</span>
                                    <div className="text_item_content">
                                        <p className="text_item_p">
                                            <b>Отправка результатов на проверку:</b>
                                        </p>
                                        <ul className="list">
                                            <li>
                                                За 7-10 дней до госпитализации отправить все результаты анализов и
                                                обследований на проверку через личный кабинет.
                                            </li>
                                            <li>
                                                Фото должны быть высокого качества, все данные должны быть читаемы
                                                (лучше всего — сканы).
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">3</span>
                                    <div className="text_item_content">
                                        <p className="text_item_p">
                                            <b>Связь с клиникой:</b>
                                        </p>
                                        <ul className="list">
                                            <li>
                                                За 3 дня до госпитализации свяжется менеджер ОМС отдела Гута клиник
                                                (Архипова Мунира) для предварительного оформления в стационар.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">В день госпитализации</div>
                        </div>
                        <div className="article_body">
                            <div className="text_items">
                                <div className="text_item">
                                    <span className="text_item_count">1</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b>Прийти на ресепшн, сообщить ФИО</b>
                                        </p>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">2</span>
                                    <div className="text_item_content">
                                        <p className="text_item_p">
                                            <b>Привезти все документы в оригинале:</b>
                                        </p>
                                        <ul className="list">
                                            <li>Паспорт</li>
                                            <li>Полис ОМС</li>
                                            <li>СНИЛС</li>
                                            <li>Направление 057у</li>
                                            <li>Оригиналы всех анализов и обследований с печатями и подписями врачей.
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">3</span>
                                    <div className="text_item_content">
                                        <p className="text_item_p">
                                            <b>Взять с собой:</b>
                                        </p>
                                        <ul className="list">
                                            <li>Домашнюю одежду</li>
                                            <li>Тапочки</li>
                                            <li>Зарядку для телефона</li>
                                            <li>Средства личной гигиены</li>
                                            <li>
                                                Оригиналы всех анализов и обследований с печатями и подписями врачей.
                                            </li>
                                            <li>
                                                Корсет средней жесткости (или воротник при операции на шейный отдел
                                                позвоночника)
                                            </li>
                                            <li>Компрессионные чулки выше колена 2-й степени компрессии</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Дополнительные рекомендации</div>
                        </div>
                        <div className="article_body">
                            <div className="text_items">
                                <div className="text_item">
                                    <span className="text_item_count">1</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b
                                            >Внимательно проверяйте все результаты анализов и обследований, включая
                                                наличие всех необходимых показателей и корректность данных.</b
                                            >
                                        </p>
                                    </div>
                                </div>
                                <div className="text_item">
                                    <span className="text_item_count">2</span>
                                    <div className="text_item_content">
                                        <p>
                                            <b
                                            >При возникновении противопоказаний (открытые раны, инфекции, обострение
                                                хронических заболеваний) операция может быть отменена или перенесена.</b
                                            >
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <AsideInfo title='Информация' />
        </main>
    )
}
