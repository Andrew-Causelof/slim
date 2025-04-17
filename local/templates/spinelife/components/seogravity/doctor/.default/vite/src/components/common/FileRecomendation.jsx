import React from 'react';
import PropTypes from 'prop-types';

function FileRecomendation({ title = '', url }) {
  const handlePrint = () => {
    const printWindow = window.open(url, '_blank');
    if (printWindow) {
      printWindow.focus();
      printWindow.onload = () => {
        printWindow.print();
      };
    } else {
      alert('Не удалось открыть окно для печати. Разрешите всплывающие окна.');
    }
  };

  return (
    <div className="text_unit">
      <a href={url} target="_blank" className="text_unit_icon"></a>
      <div className="text_unit_title">{title}</div>
      <div className="text_unit_actions actions">
        <button className="print_btn" onClick={handlePrint}></button>
        <a href={url} className="pdf_btn" target="_blank" rel="noopener noreferrer"></a>
      </div>
    </div>
  );
}

FileRecomendation.propTypes = {
  title: PropTypes.string.isRequired,
  url: PropTypes.string.isRequired,
};

export default FileRecomendation;
