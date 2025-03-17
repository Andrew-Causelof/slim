import React from 'react'
import PropTypes from 'prop-types'

function FileRecomendation({ title = '' }) {
  return (
    <div className="text_unit">
      <span className="text_unit_icon"></span>
      <div className="text_unit_title">{title}</div>
      <div className="text_unit_actions actions">
        <span className="print_btn"></span>
        <span className="pdf_btn"></span>
      </div>
    </div>
  )
}


FileRecomendation.propTypes = {
  title: PropTypes.string.isRequired, // Заголовок статьи
};

export default FileRecomendation
