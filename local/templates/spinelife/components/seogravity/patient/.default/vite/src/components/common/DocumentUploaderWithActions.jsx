import { useState } from 'react';
import PropTypes from 'prop-types';
import { useUserStore } from '../../store';

const MAX_FILE_SIZE_MB = 10; // Максимальный размер файла в МБ
const ALLOWED_FORMATS = ['jpeg', 'png', 'pdf', 'doc', 'docx']; // Допустимые форматы

 //@TODO привязать к реальному ID авторизованного пациента
export default function DocumentUploaderWithActions({
  userId = 3, //@TODO ID пользователя (нужно динамически определять)
  fieldName,
  title,
  notice = '',
  items = [],
  actions = {}
}) {
  const { userData, uploadFile, deleteFile, saveUserData } = useUserStore();
  const [error, setError] = useState('');

  const handleFileUpload = async (e) => {
    const files = Array.from(e.target.files);

    const validatedFiles = files.filter((file) => {
      const fileExtension = file.name.split('.').pop().toLowerCase();
      const fileSizeMB = file.size / (1024 * 1024);

      if (!ALLOWED_FORMATS.includes(fileExtension)) {
        setError(`Недопустимый формат файла: ${file.name}`);
        return false;
      }

      if (fileSizeMB > MAX_FILE_SIZE_MB) {
        setError(`Файл слишком большой: ${file.name} (${fileSizeMB.toFixed(2)} МБ)`);
        return false;
      }

      setError('');
      return true;
    });

    try {
      await Promise.all(validatedFiles.map((file) => uploadFile(userId, fieldName, file)));
      await saveUserData(userId);
      console.log('Файлы успешно загружены и сохранены!');
    } catch (error) {
      console.error('Ошибка загрузки файлов:', error);
    }
  };

  const handleFileRemove = async (fileId) => {
    try {
      await deleteFile(userId, fieldName, fileId);
      await saveUserData(userId);
      console.log('Файл успешно удален и сохранен!');
    } catch (error) {
      console.error('Ошибка удаления файла:', error);
    }
  };

  return (
    <div className="form_controls form_controls-files">
      <div className={`control control-files ${error ? 'control-files-err' : ''}`}>
        {/* Заголовок с кнопками */}
        <span className="control_title control_title-notice">
          {title}
          {notice && (
            <div className="control_notice">
              <span className="control_notice_icon"></span>
              <div className="control_notice_content">
                <p>{notice}</p>
              </div>
            </div>
          )}
          {/* Дополнительные действия */}
          <div className="control_title_actions">
            {actions.print && <button type="button" className="print_btn" onClick={actions.print}></button>}
            {actions.download && <button type="button" className="pdf_btn" onClick={actions.download}></button>}
          </div>
        </span>

        {/* Список элементов */}
        {items && items.length > 0 && (
          <ul className="control_list">
            {items.map((item, index) => (
              <li key={index}>{item}</li>
            ))}
          </ul>
        )}

        {/* Блок загрузки файлов */}
        <div className="upload">
          <input
            id={`${fieldName}-files`}
            type="file"
            className="upload_input"
            multiple
            onChange={handleFileUpload}
          />
          <label htmlFor={`${fieldName}-files`} className="upload_btn btn btn-main">
            <span></span> Загрузить
          </label>
          <div className="upload_info">
            <p>Максимальный размер файла: {MAX_FILE_SIZE_MB} МБ.</p>
            <p>Допустимые форматы: {ALLOWED_FORMATS.join(', ')}.</p>
          </div>
        </div>

        {/* Список загруженных файлов */}
        <div className="files">
          {userData.files[fieldName]?.map((file, index) => (
            <div key={index} className="files_item">
              <span className="files_item_icon"></span>
              <span className="files_item_title">{file.name}</span>
              <div className="files_item_actions">
                <button
                  type="button"
                  className="files_item_del"
                  onClick={() => handleFileRemove(file.id)}
                >
                  Удалить
                </button>
              </div>
            </div>
          ))}
        </div>

        {/* Блок с ошибкой */}
        {error && (
          <div className="alert">
            <span className="alert_icon"></span>
            <p className="alert_text">{error}</p>
          </div>
        )}
      </div>
    </div>
  );
}

DocumentUploaderWithActions.propTypes = {
  userId: PropTypes.number,
  fieldName: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired,
  notice: PropTypes.string,
  items: PropTypes.array,
  actions: PropTypes.shape({
    print: PropTypes.func,
    download: PropTypes.func,
  }),
};
