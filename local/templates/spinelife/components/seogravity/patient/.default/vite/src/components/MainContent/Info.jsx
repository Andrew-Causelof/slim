import { useUserStore } from "../../store";
import YesNoSelector from "../common/YesNoSelector";
import Description from "../common/Description";
import TextAreaField from "../common/TextAreaField";
import SelectorWithComments from "../common/SelectorWithComments";
import InfoArticle from "../common/InfoArticle";
import diseas from "../../data/diseaseList.json";
import medications from "../../data/medicationList.json";
import alergy from "../../data/alergyList.json";
import infection from "../../data/infectionList.json";
import badHabbits from "../../data/badHabbitsList.json";
import AsideProgress from '../common/AsideProgress';
import Breadcrumbs from '../common/Breadcrumbs';

export default function Info() {

    const { userData, setUserData } = useUserStore();

    return (
        <form className="main">
            <div className="content">
                <div className="content_head">
                    <Breadcrumbs current='Медицинская информация' />
                    <div className="title title-page">Медицинская информация</div>
                </div>
                <div className="content_body">

                    <InfoArticle article="Жалобы">
                        <Description tag="commentTag" title="Жалобы на здоровье" />
                        <TextAreaField
                            name="comment"
                            placeholder="Опишите, пожалуйста, основное, что вас беспокоит"
                        />
                    </InfoArticle>

                    <InfoArticle article="Хронические заболевания" className='control-g24'>
                        <Description tag="chronicDiseasesTag" title='Есть ли у вас хронические заболевания?' />
                        <YesNoSelector
                            labelYes="Есть"
                            labelNo="Нет"
                            fieldName="chronicDiseases"
                        />
                        <SelectorWithComments
                            options={diseas}
                            placeholder="Выберите один или несколько"
                            fieldName="diseaseList"
                        />
                    </InfoArticle>

                    <InfoArticle article="Приём медикаментов" className='control-g24'>
                        <Description tag="medicationsTag" title='Принимали ли ранее медикаменты' />
                        <YesNoSelector
                            labelYes="Есть"
                            labelNo="Нет"
                            fieldName="medications"
                        />
                        <SelectorWithComments
                            options={medications}
                            placeholder="Выберите один или несколько"
                            fieldName="medicationList"
                        />
                    </InfoArticle>

                    <InfoArticle article='Предыдущие операции' className='control-g24'>
                        <Description tag="surgeriesTag" title='Были у вас ранее операции?' />
                        <YesNoSelector labelYes="Да" labelNo="Нет" fieldName="surgeries" />
                        <TextAreaField id="surgeriesComment" name="surgeriesComment" placeholder="Напишите пожалуйста какие операции у вас были..." />
                    </InfoArticle>

                    <InfoArticle article='Аллергии и лекарственная непереносимость' className='control-g24'>
                        <Description tag="alergyTag" title='У вас есть аллергия или лекарственная неперносимость?' />
                        <YesNoSelector labelYes="Да" labelNo="Нет" fieldName="alergy" />
                        <SelectorWithComments
                            options={alergy}
                            placeholder="Выберите один или несколько"
                            fieldName="alergyList"
                        />
                    </InfoArticle>

                    <InfoArticle article='Инфекционные заболевания' className='control-g24'>
                        <Description tag="infectionTag" title='Были ли или есть у вас инфекционные заболевания?' />
                        <YesNoSelector labelYes="Да" labelNo="Нет" fieldName="infection" />
                        <SelectorWithComments
                            options={infection}
                            placeholder="Выберите один или несколько"
                            fieldName="infectionList"
                        />
                    </InfoArticle>

                    <InfoArticle article='Наследственные заболевания'>
                        <Description tag="inheritanceDiseases" title='Есть ли у вас наследственные заболевания?' />
                        <TextAreaField id="inheritanceDiseasesComment" name="inheritanceDiseasesComment" placeholder="Напишите пожалуйста есть ли у вас наследственные заболевания..." />
                    </InfoArticle>

                    <InfoArticle article='Вредные привычки' className='control-g24'>
                        <Description tag="badHabbitsTag" title='Есть ли у вас вредные привычки?' />
                        <YesNoSelector labelYes="Да" labelNo="Нет" fieldName="badHabbits" />
                        <SelectorWithComments
                            options={badHabbits}
                            placeholder="Выберите один или несколько"
                            fieldName="badHabbitsList"
                        />
                    </InfoArticle>

                    <InfoArticle article='Беременность' className='control-g24'>
                        <Description tag="pregnantTag" title=' Беременны в настоящий момент?' />
                        <YesNoSelector labelYes="Да" labelNo="Нет" fieldName="pregnant" />
                    </InfoArticle>

                    <InfoArticle article='Больничный лист' className='control-g24'>
                        <Description tag="sickLeaveTag" title='Нужен ли больничный лист?' />
                        <YesNoSelector labelYes="Да" labelNo="Нет" fieldName="sickLeave" />
                    </InfoArticle>

                </div>
            </div>

            <AsideProgress
                title="Информация"
                progress={userData.progress.medical}
                onClick={() => setUserData('activeTab', 'docs')}
            />

        </form>
    )
}
