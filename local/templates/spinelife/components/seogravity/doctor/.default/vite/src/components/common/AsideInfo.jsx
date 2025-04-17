import PropTypes from 'prop-types';

export default function AsideInfo({ title = '', pdfUrl = '' }) {
  const handlePrint = () => {
    const printWindow = window.open(pdfUrl, '_blank');
    if (printWindow) {
      printWindow.focus();
      printWindow.onload = () => printWindow.print();
    } else {
      alert('Не удалось открыть документ для печати.');
    }
  };

  return (
    <aside className="aside aside-right">
      <div className="widget">
        <div className="widget_title">{title}</div>
        <div className="widget_actions widget_actions-col">
          <button
            className="btn btn-main btn-fw widget_print"
            onClick={handlePrint}
          >
            Распечатать <span className="widget_print"></span>
          </button>
          <a
            download
            href={pdfUrl}
            className="btn btn-main btn-fw"
            target="_blank"
            rel="noreferrer"
          >
            Скачать в формате PDF
          </a>
        </div>
      </div>
    </aside>
  );
}

AsideInfo.propTypes = {
  title: PropTypes.string,
  pdfUrl: PropTypes.string,
};
