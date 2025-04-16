import React, { useEffect, useState } from 'react';
import Dropdown from '../../common/Dropdown';
import { useNotification } from '../../../context/NotificationContext';
import operationsData from '../../../data/dummyOperations.json';
import { usePatientStore } from '../../../store/patientStore';
import { useAppStore } from '../../../store/store';
import Selector from '../../common/Selector';

function PatientOperations({ userData }) {
  const { operations, setOperations, savePatientOperations } =
    usePatientStore();

  useEffect(() => {
    if (userData?.operations) {
      setOperations('planned', userData.operations.planned || []);
      setOperations('past', userData.operations.past || []);
    }
  }, [userData]);

  const notyf = useNotification();

  const { selectedPatientId } = useAppStore();

  const handleSelect = async (type, selectedOptions) => {
    setOperations(type, selectedOptions); // Моментально обновляем Zustand
    notyf.success('Изменения сохранены!');

    console.log('selectedOptions', selectedOptions);

    //Сохраняем изменения в базе данных
    await savePatientOperations(selectedPatientId, {
      planned: type === 'planned' ? selectedOptions : operations.planned,
      past: type === 'past' ? selectedOptions : operations.past,
    });
  };

  const renderOperationList = (title, type) => (
    <article className="article">
      <div className="article_head">
        <div className="title title-article">{title}</div>
      </div>
      <div className="article_body">
        <div className="form_controls">
          <div className="control">
            <span className="control_title">Выбрать вид операции</span>

            <Selector
              options={operationsData.map((operation) => operation.name)}
              type="multiple"
              placeholder="Выберите одну или несколько операций"
              onChange={(selectedOptions) =>
                handleSelect(type, selectedOptions)
              }
              value={operations[type] || []}
            />
          </div>
        </div>
      </div>
    </article>
  );

  return (
    <Dropdown title="Данные об операциях">
      {renderOperationList('Планируемая операция', 'planned')}
      {renderOperationList('Прошлая операция', 'past')}
    </Dropdown>
  );
}

export default PatientOperations;
