import PropTypes from 'prop-types';

export default function ProgressTab({ text, progress, active, onClick }) {
    return (
        <li
            className={`menu_item ${active ? 'menu_item-active' : ''}`}
            onClick={onClick} // Обработчик клика
        >
            <a className="menu_link">
                <span className="menu_link_status"></span>
                <div className="menu_link_content">
                    <div className="menu_link_text">{text}</div>
                    <div className={`progress ${active ? 'progress-dark' : ''}`}>
                        <div className="progress_bar">
                            <span
                                className="progress_line"
                                style={{ width: `${progress}%` }}
                            ></span>
                        </div>
                        <p className="progress_text">
                            Заполнено <span className="progress_value">{progress}%</span>
                        </p>
                    </div>
                </div>
            </a>
        </li>
    );
}

ProgressTab.propTypes = {
    text: PropTypes.string.isRequired, // Название вкладки
    progress: PropTypes.number.isRequired, // Прогресс в процентах
    active: PropTypes.bool, // Указывает, активен ли таб
    onClick: PropTypes.func, // Обработчик клика
};
