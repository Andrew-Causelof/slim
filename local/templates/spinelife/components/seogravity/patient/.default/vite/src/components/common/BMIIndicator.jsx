import { useEffect, useState } from 'react';
import Modal from 'react-modal';
import InputField from '../common/InputField';
import PropTypes from 'prop-types';
import { REACT_APP_ROOT } from "../../config.js";

Modal.setAppElement(`#${REACT_APP_ROOT}`);

export default function BMIIndicator({ height, weight }) {
  const [bmi, setBmi] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);

  useEffect(() => {
    if (!height || !weight) return;

    const heightInMeters = parseFloat(height) / 100;
    const weightNum = parseFloat(weight);

    if (!isNaN(heightInMeters) && !isNaN(weightNum) && heightInMeters > 0) {
      const bmiValue = weightNum / (heightInMeters * heightInMeters);
      setBmi(bmiValue.toFixed(1));

      if (bmiValue > 40) {
        setIsModalOpen(true);
      }
    } else {
      setBmi('');
    }
  }, [height, weight]);

  return (
    <>
      <InputField
        type="text"
        name="weightIndex"
        value={bmi}
        onChange={() => {}}
        placeholder=""
        disabled={true}
        readOnly={true}
      />

      <Modal
        isOpen={isModalOpen}
        onRequestClose={() => setIsModalOpen(false)}
        contentLabel="Ограничение по операции"
        className="modal"
        overlayClassName="modal-overlay BMIIndicator"
      >
        <h2 className='title-page'>Ограничение по операции</h2>
        <p className='title-article'>
          Индекс массы тела превышает 40. В этом случае операция невозможна.
        </p>
        <button className="btn btn-main" onClick={() => setIsModalOpen(false)}>
          Понятно
        </button>
      </Modal>
    </>
  );
}

BMIIndicator.propTypes = {
  height: PropTypes.string,
  weight: PropTypes.string,
};
