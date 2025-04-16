import { useState, useEffect } from 'react';
import PropTypes from 'prop-types';

export default function SingleSelector({ options, onChange, placeholder, value }) {
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const [selectedItem, setSelectedItem] = useState(null);
  const [validationClass, setValidationClass] = useState('');

  // Установка выбранного значения при инициализации/обновлении
  useEffect(() => {
    if (typeof value === 'object' && value !== null) {
      setSelectedItem(value);
    } else {
      const matched = options.find((opt) => opt.name === value || opt.id === value);
      setSelectedItem(matched || null);
    }
  }, [value, options]);

  const handleSelect = (option) => {
    setSelectedItem(option);
    setIsDropdownOpen(false);
    onChange(option); // передаём объект {id, name}
  };

  const toggleDropdown = () => {
    setIsDropdownOpen(!isDropdownOpen);
  };

  useEffect(() => {
    setValidationClass(selectedItem ? 'ok' : 'err');
  }, [selectedItem]);



  return (
    <div className={`select ${isDropdownOpen ? 'show' : ''} ${validationClass}`}>
      <button
        type="button"
        className="select_toggle"
        onClick={toggleDropdown}
      >
        {selectedItem?.name || placeholder}
      </button>

      {isDropdownOpen && (
        <div className="select_dropdown">
          <ul className="select_options">
            {options.map((option) => (
              <li
                key={option.id}
                className={`select_option ${selectedItem?.id === option.id ? 'select_option-selected' : ''}`}
                onClick={() => handleSelect(option)}
              >
                <div className="radio_item">
                  <input
                    type="radio"
                    checked={selectedItem?.id === option.id}
                    readOnly
                  />
                  <span className="radio_item_visible"></span>
                </div>
                <span className="select_option_text">{option.name}</span>
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  );
}

SingleSelector.propTypes = {
  options: PropTypes.arrayOf(PropTypes.shape({
    id: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
    name: PropTypes.string.isRequired,
  })).isRequired,
  onChange: PropTypes.func.isRequired,
  placeholder: PropTypes.string,
  value: PropTypes.oneOfType([PropTypes.string, PropTypes.object]), // можно и строку, и объект
};
