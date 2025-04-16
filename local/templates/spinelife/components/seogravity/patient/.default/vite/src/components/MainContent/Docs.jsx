import DocumentUploader from '../common/DocumentUploader';
import DocsArticle from '../common/DocsArticle';
import Breadcrumbs from '../common/Breadcrumbs';
import DocumentUploaderWithActions from '../common/DocumentUploaderWithActions'
import AsideInfo from '../common/AsideInfo';
import ErrorBoundary from '../common/ErrorBoundary';

export default function Docs() {


    const handlePrint = () => {
        console.log('Печать документа...');
    };

    const handleDownload = () => {
        console.log('Скачивание PDF...');
    };

    return (
        <form className="main">
            <div className="content">
                <div className="content_head">
                    <Breadcrumbs current='Документы и анализы пациента' />
                    <div className="title title-page">Документы и анализы пациента</div>
                </div>

                <div className="content_body">

                    <DocsArticle article='Основные документы'>
                        <ErrorBoundary>
                            <DocumentUploader
                                fieldName="passport_files"
                                title="Копия паспорта"
                                notice="Копия паспорта сканы всех страниц"
                            />
                        </ErrorBoundary>

                        <DocumentUploader
                            fieldName="polis_files"
                            title="Страховой полис"
                            notice="Страховой полис сканы всех страниц"
                        />
                        <DocumentUploader
                            fieldName="snils_files"
                            title="СНИЛС"
                            notice="СНИЛС сканы всех страниц"
                        />
                    </DocsArticle>

                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Лабораторные анализы</div>
                        </div>
                        <div className="article_body">
                            <div className="alert alert-v2">
                                <p className="alert_text">
                                    Основные лабораторные исследования (срок действия – 14 дней, если не указано
                                    иное)
                                </p>
                                <span className="alert_icon"></span>
                            </div>
                            <DocumentUploader
                                fieldName="general_files"
                                title="Общий анализ крови с лейкоцитарной формулой и тромбоцитами + СОЭ"
                                notice="Общий анализ крови с лейкоцитарной формулой и тромбоцитами + СО"
                            />


                            <DocumentUploaderWithActions
                                fieldName="coagulogram_files"
                                title="Коагулограмма"
                                notice="Коагулограмма"
                                items={[
                                    'МНО (международное нормализованное отношение)',
                                    'АЧТВ (активированное частичное тромбопластиновое время)',
                                    'Фибриноген',
                                    'Протромбиновое время',
                                    'Тромбиновое время',
                                    'Д-димер',
                                ]}
                                actions={{ print: handlePrint, download: handleDownload }}
                            />

                            <DocumentUploaderWithActions
                                fieldName="blood-biochemical_files"
                                title="Биохимический анализ крови"
                                notice="Биохимический анализ крови."
                                items={[
                                    'Глюкоза',
                                    'Общий белок',
                                    'Билирубин (общий, прямой, непрямой)',
                                    'АЛТ (аланинаминотрансфераза)',
                                    'АСТ (аспартатаминотрансфераза)',
                                    'Креатинин',
                                    'Мочевина',
                                    'Калий, натрий, хлор',
                                    'Альбумин',
                                ]}
                                actions={{ print: handlePrint, download: handleDownload }}
                            />

                            <DocumentUploaderWithActions
                                fieldName="blood-infectious_files"
                                title="Инфекционно-иммунологический анализ крови (pdf / jpg / png)"
                                notice="Далеко-далеко за словесными горами в стране гласных, и согласных живут рыбные тексты."
                                items={[
                                    'RW (сифилис) (3 месяца)',
                                    'Hbs-антиген (гепатит В) (3 месяца)',
                                    'Анти-HCV (гепатит С) (3 месяца)',
                                    'ВИЧ (3 месяца)',
                                ]}
                                actions={{ print: handlePrint, download: handleDownload }}
                            />

                            <DocumentUploader
                                fieldName="blood-group_files"
                                title="Определение группы крови и резус-фактора (бессрочно)"
                                notice="Далеко-далеко за словесными горами в стране гласных, и согласных живут рыбные тексты."
                            />
                            <DocumentUploader
                                fieldName="blood-phenotyping_files"
                                title="Фенотипирование эритроцитов (бессрочно) (pdf / jpg / png)"
                                notice="Далеко-далеко за словесными горами в стране гласных, и согласных живут рыбные тексты."
                            />

                            <DocumentUploader
                                fieldName="urine-general_files"
                                title="Общий анализ мочи"
                                notice="Далеко-далеко за словесными горами в стране гласных, и согласных живут рыбные тексты."
                            />


                        </div>
                    </article>

                    <DocsArticle article="Специальные лабораторные исследования:">
                        <DocumentUploader
                            fieldName="covid_files"
                            title="ПЦР на COVID-19 из носоглотки и ротоглотки (не ранее чем за 1-2 дня до госпитализации, результат действителен 48 часов)"
                            notice="Далеко-далеко за словесными горами в стране гласных, и согласных живут рыбные тексты."
                        />
                    </DocsArticle>

                </div>
            </div>

            <AsideInfo title='Информация' />
        </form>
    )
}
