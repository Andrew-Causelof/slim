import Breadcrumbs from '../common/Breadcrumbs';
import AsideInfo from '../common/AsideInfo'
import FileRecomendation from '../common/FileRecomendation'
import VideoRecomendation from '../common/VideoRecomendation'

export default function Recomendation() {
    return (
        <main className="main">
            <div className="content">
                <div className="content_head">
                    <Breadcrumbs current='Рекомендации после операции' />
                    <div className="title title-page">Рекомендации после операции</div>
                </div>
                <div className="content_body">
                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Видео рекомендации</div>
                        </div>
                        <div className="article_body">
                            <div className="video_items">
                                <VideoRecomendation 
                                    title='Послеопреационная зарядка и физические упражнения.' 
                                    img='http://sl-crm.seo-gravity.ru/assets/img/video1.jpg'
                                    url='#'
                                />
                                <VideoRecomendation 
                                    title='Послеопреационная зарядка и физические упражнения.' 
                                    img='http://sl-crm.seo-gravity.ru/assets/img/video2.jpg'
                                    url='#'
                                />
                                <VideoRecomendation 
                                    title='Послеопреационная зарядка и физические упражнения.' 
                                    img='http://sl-crm.seo-gravity.ru/assets/img/video3.jpg'
                                    url='#'
                                />
                            </div>
                        </div>
                    </article>
                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Текстовые рекомендации</div>
                        </div>
                        <div className="article_body">
                            <div className="text_items">
                                <FileRecomendation title="Послеопреационная зарядка и физические упражнения"/>
                                <FileRecomendation title="Рекомендации по питанию и пищевым добавкам"/>
                                <FileRecomendation title="Рекомендации по лекарствам"/>
                                <FileRecomendation title="Рекомендации по питанию и пищевым добавкам"/>
                                <FileRecomendation title="Послеопреационная зарядка и физические упражнения"/>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <AsideInfo title='Информация'/>
        </main>
    )
}
