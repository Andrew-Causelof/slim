import React from 'react';
import PropTypes from 'prop-types';

const levels = [
  { value: 0, label: 'Не болит' },
  { value: 1, label: '' },
  { value: 2, label: 'Средне' },
  { value: 3, label: '' },
  { value: 4, label: 'Терпимо' },
  { value: 5, label: '' },
  { value: 6, label: 'Сильная боль' },
  { value: 7, label: '' },
  { value: 8, label: 'Очень сильная боль' },
  { value: 9, label: '' },
  { value: 10, label: 'Невыносимо терпеть' },
];

export default function PainScale({ value, onChange }) {
  return (
    <div className="pain-scale-container">
        <div className="top-container">
        <label className="pain-label control_title">Оцените интенсивность боли:</label>
        <div className="current-pain control_title">Вы выбрали: {value}</div>
        </div>

        <div className="pain-faces">
        {levels.map((level) => (
          <div key={level.value} className="pain-level">
            <div className="label">{level.label}</div>
          </div>
        ))}
      </div>

      <input
        type="range"
        min="0"
        max="10"
        value={value}
        onChange={(e) => onChange(Number(e.target.value))}
        className="pain-range"
      />

      <div className="pain-faces">
        {levels.map((level) => (
          <div key={level.value} className="pain-level">
            <div className={`face face-${level.value}`}></div>
          </div>
        ))}
      </div>

      
    </div>
  );
}

PainScale.propTypes = {
  value: PropTypes.number.isRequired,
  onChange: PropTypes.func.isRequired,
};
