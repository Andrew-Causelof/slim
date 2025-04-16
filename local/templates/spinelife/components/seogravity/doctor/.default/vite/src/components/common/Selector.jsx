import { useState, useEffect } from 'react';
import PropTypes from 'prop-types';

export default function Selector({
  options,
  type = 'multiple',
  onChange,
  placeholder,
  value = [],
}) {
  const [isDropdownOpen, setIsDropdownOpen] = useState(false);
  const [selectedItems, setSelectedItems] = useState(value || []);

  // Синхронизируем selectedItems с приходящим value
  useEffect(() => {
    if (Array.isArray(value)) {
      setSelectedItems(value);
    }
  }, [value]);

  const handleSelect = (option) => {
    let updatedItems;
    if (type === 'multiple') {
      if (selectedItems.includes(option)) {
        updatedItems = selectedItems.filter((item) => item !== option);
      } else {
        updatedItems = [...selectedItems, option];
      }
    } else {
      updatedItems = [option];
    }

    setSelectedItems(updatedItems);
    onChange(updatedItems);
  };

  const toggleDropdown = () => {
    setIsDropdownOpen(!isDropdownOpen);
  };

  const renderSelectedItems = () => {
    return selectedItems.map((item, index) => (
      <div key={index} className="selected_item">
        <div className="selected_item_head">
          <span className="selected_item_title">{item}</span>
          <button
            type="button"
            className="selected_item_del"
            onClick={() => handleSelect(item)}
          >
            Удалить
          </button>
        </div>
      </div>
    ));
  };

  return (
    <div className={`select ${isDropdownOpen ? 'show' : ''}`}>
      <button type="button" className="select_toggle" onClick={toggleDropdown}>
        {selectedItems.length > 0 ? selectedItems.join(', ') : placeholder}
      </button>

      {isDropdownOpen && (
        <div className="select_dropdown">
          <ul className="select_options">
            {options.map((option, index) => (
              <li
                key={index}
                className={`select_option ${
                  selectedItems.includes(option) ? 'select_option-selected' : ''
                }`}
                onClick={() => handleSelect(option)}
              >
                <div className="checkbox_item">
                  <input
                    type={type === 'multiple' ? 'checkbox' : 'radio'}
                    checked={selectedItems.includes(option)}
                    readOnly
                  />
                  <span className="checkbox_item_visible"></span>
                </div>
                <span className="select_option_text">{option}</span>
              </li>
            ))}
          </ul>
        </div>
      )}

      <div className="selected">{renderSelectedItems()}</div>
    </div>
  );
}

Selector.propTypes = {
  options: PropTypes.array.isRequired,
  type: PropTypes.oneOf(['single', 'multiple']),
  onChange: PropTypes.func.isRequired,
  placeholder: PropTypes.string,
  value: PropTypes.array, // <-- Новое свойство
};
