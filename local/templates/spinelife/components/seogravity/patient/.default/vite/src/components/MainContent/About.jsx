import InputField from "../common/InputField";
import PhoneInputField from "../common/PhoneInputField";
import AirDatepickerField from "../common/AirDatepickerField";
import GenderSelector from "../common/GenderSelector";
import SnilsInputField from "../common/SnilsInputField";
import SingleSelector from "../common/SingleSelector";
import { useUserStore } from "../../store";
import regions from "../../data/regions.json";
import Description from "../common/Description";
import AsideProgress from '../common/AsideProgress';
import Breadcrumbs from '../common/Breadcrumbs';

export default function About() {
    const { userData, setUserData } = useUserStore();

    const handleInputChange = (field) => (e) => {
        setUserData(field, e.target.value); // Обновляем состояние поля
    };
    const handleDataInputChange = (field) => (e) => {
        setUserData(field, e); // Обновляем состояние поля даты
    };

    const regionOptions = regions.map(item => ({
        id: item.id,
        name: item.name,
      }));

      console.log(userData)

    return (
        <form className="main">
            <div className="content">
                <div className="content_head">
                    <Breadcrumbs current='Информация о клиенте' />
                    <div className="title title-page">Информация о пациенте</div>
                </div>
                <div className="content_body">
                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Основная информация</div>
                        </div>
                        <div className="article_body">

                            <GenderSelector />

                            <div className="form_controls form_controls-grid">

                                <div className="control">
                                    <label className="control_title">Фамилия</label>
                                    <InputField
                                        type="text"
                                        name="lastname"
                                        value={userData.lastname || ''}
                                        placeholder="Ваша фамилия..."
                                        onChange={handleInputChange('lastname')}
                                    />
                                </div>

                                <div className="control">
                                    <label className="control_title">Имя</label>
                                    <InputField
                                        type="text"
                                        name="firstname"
                                        value={userData.firstname || ''}
                                        placeholder="Ваше имя..."
                                        onChange={handleInputChange('firstname')}
                                    />
                                </div>
                                <div className="control">
                                    <label className="control_title">Отчество</label>
                                    <InputField
                                        value={userData.thirdname || ''}
                                        type="text"
                                        name="thirdname"
                                        onChange={handleInputChange('thirdname')}
                                        placeholder="Ваше отчество..."
                                    // disabled={true} 
                                    />
                                </div>
                                <label className="control_title control control-date" htmlFor="birthday"
                                >Дата рождения
                                    <AirDatepickerField
                                        id="birthday"
                                        type="text"
                                        name="birthday"
                                        placeholder="Выбрать дату"
                                        className="date"
                                        value={userData.birthday || ''}
                                        onChange={handleDataInputChange('birthday')}
                                    />
                                </label>
                                <div className="control">
                                    <label className="control_title">Рост, см</label>
                                    <InputField
                                        type="text"
                                        name="height"
                                        value={userData.height || ''}
                                        onChange={handleInputChange('height')}
                                        placeholder="Укажите ваш рост"
                                    />
                                </div>
                                <div className="control">
                                    <label className="control_title">Вес, кг</label>
                                    <InputField
                                        type="text"
                                        name="weight"
                                        value={userData.weight || ''}
                                        onChange={handleInputChange('weight')}
                                        placeholder="Укажите ваш вес"
                                    />
                                </div>
                            </div>
                        </div>
                    </article>
                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Контактная информация</div>
                        </div>
                        <div className="article_body">
                            <div className="form_controls form_controls-grid">
                                <div className="control">
                                    <label className="control_title">Телефон</label>
                                    <PhoneInputField
                                        name="phone"
                                        value={userData.phone || ''}
                                        onChange={handleInputChange('phone')}
                                        placeholder="+7 (___) ___ - __ - __"
                                    />
                                </div>
                                <div className="control">
                                    <label className="control_title">Доп. телефон (при наличии)</label>
                                    <PhoneInputField
                                        name="phone2"
                                        value={userData.phone2 || ''}
                                        onChange={handleInputChange('phone2')}
                                        placeholder="+7 (___) ___ - __ - __"
                                    />
                                </div>
                                <div className="control">
                                    <label className="control_title">Электронная почта</label>
                                    <InputField
                                        type="text"
                                        name="email"
                                        value={userData.email || ''}
                                        onChange={handleInputChange('email')}
                                        placeholder="Укажите ваш e-mail"
                                    />

                                </div>
                            </div>
                        </div>
                    </article>
                    <article className="article">
                        <div className="article_head">
                            <div className="title title-article">Личные документы</div>
                        </div>
                        <div className="article_body">
                            <div className="form_controls form_controls-grid">
                                <div className="control">
                                    <label
                                        className="control_title control_title-notice">
                                        Номер страхового полиса
                                        <Description tag="polisTag" />
                                    </label>
                                    <InputField
                                        type="text"
                                        name="polis"
                                        value={userData.polis || ''}
                                        onChange={handleInputChange('polis')}
                                        placeholder="Введите 16 цифр полиса..."
                                    />
                                </div>
                                <div className="control">
                                    <label
                                        className="control_title control_title-notice">
                                        Регион полиса
                                        <Description tag="polisRegionTag" />
                                    </label>
                                    <SingleSelector
                                        options={regionOptions}
                                        onChange={(value) => setUserData('polisRegion', value)} // Обновление polisRegion в глобальном состоянии
                                        value={userData.polisRegion || ''} // Инициализация с данным значением
                                        placeholder="Выберите регион полиса..."
                                    />
                                </div>
                                <div className="control">
                                    <label
                                        className="control_title control_title-notice">
                                        СНИЛС
                                        <Description tag="snilsTag" />
                                    </label>
                                    <SnilsInputField
                                        name="snils"
                                        value={userData.snils || ''}
                                        onChange={handleInputChange('snils')}
                                        placeholder="Введите номер СНИЛС..."
                                    />
                                </div>
                                <div className="control">
                                    <label
                                        className="control_title control_title-notice">
                                        Серия и номер паспорта
                                        <Description tag="passportTag" />
                                    </label>
                                    <InputField
                                        type="text"
                                        name="passport"
                                        value={userData.passport || ''}
                                        onChange={handleInputChange('passport')}
                                        placeholder="Введите 10 цифр паспорта..."
                                    />
                                </div>
                                <label className="control_title control control-date" htmlFor="passportDate">Дата выдачи
                                    <AirDatepickerField
                                        id="passportDate"
                                        type="text"
                                        name="passportDate"
                                        placeholder="Выбрать дату"
                                        value={userData.passportDate || ''}
                                        onChange={handleDataInputChange('passportDate')}
                                        className="date"
                                    />
                                </label>
                                <div className="control">
                                    <label className="control_title control_title-notice">
                                        Кем выдан
                                        <Description tag="passportFromTag" />
                                    </label>
                                    <InputField
                                        type="text"
                                        name="passport-from"
                                        placeholder="Введите кем выдано..."
                                        value={userData.passportFrom || ''}
                                        onChange={handleInputChange('passportFrom')}
                                    />
                                </div>
                                <div className="control">
                                    <label className="control_title control_title-notice">
                                        Город регистрации
                                        <Description tag="cityTag" />
                                    </label>
                                    <InputField
                                        type="text"
                                        name="city"
                                        placeholder="Город..."
                                        value={userData.city || ''}
                                        onChange={handleInputChange('city')}
                                    />
                                </div>
                                <div className="control control-x2">
                                    <label className="control_title control_title-notice">
                                        Адрес регистрации
                                        <Description tag="addressTag" />
                                    </label>
                                    <InputField
                                        type="text"
                                        name="address"
                                        placeholder="Адрес..."
                                        value={userData.address || ''}
                                        onChange={handleInputChange('address')}
                                    />
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
            <AsideProgress
                title="Информация"
                progress={userData.progress.general}
                onClick={() => setUserData('activeTab', 'info')}
            />
        </form>
    )
}
