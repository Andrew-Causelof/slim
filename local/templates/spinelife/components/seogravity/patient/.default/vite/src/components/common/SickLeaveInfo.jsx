import React from "react";
import InfoArticle from "./InfoArticle";
import Description from "./Description";
import YesNoSelector from "./YesNoSelector";
import InputField from "./InputField";
import AirDatepickerField from "./AirDatepickerField";
import { useUserStore } from "../../store";

export default function SickLeaveInfo() {
  const { userData, setUserData } = useUserStore();

  const handleChange = (field) => (value) => {
    setUserData(field, value);
  };

  const sickLeave = userData?.sickLeave === "yes";

  return (
    <InfoArticle article="Больничный лист" className="control-g24">
      <Description tag="sickLeaveTag" title="Нужен ли больничный лист?" />
      <YesNoSelector labelYes="Да" labelNo="Нет" fieldName="sickLeave" />

      {sickLeave && (
        <div className="form_controls form_controls-grid">
          <div className="control">
            <label class="control_title">Номер больничного листа</label>
            <InputField
              name="sickLeaveNumber"
              value={userData.sickLeaveNumber || ""}
              onChange={(e) => handleChange("sickLeaveNumber")(e.target.value)}
              placeholder="Введите номер"
            />
          </div>
          <div className="control">
            <label className="control_title">Дата начала</label>
            <AirDatepickerField
              id="sickLeaveFrom"
              name="sickLeaveFrom"
              value={userData.sickLeaveFrom || ""}
              onChange={handleChange("sickLeaveFrom")}
              placeholder="Дата начала"
              className="date"
            />
          </div>

          <div className="control">
            <label className="control_title">Дата окончания</label>
            <AirDatepickerField
              id="sickLeaveTo"
              name="sickLeaveTo"
              value={userData.sickLeaveTo || ""}
              onChange={handleChange("sickLeaveTo")}
              placeholder="Дата окончания"
              className="date"
            />
          </div>

          <div className="control">
            <label className="control_title">Код диагноза</label>
            <InputField
              label="Код диагноза"
              name="sickLeaveDiagnosisCode"
              value={userData.sickLeaveDiagnosisCode || ""}
              onChange={(e) =>
                handleChange("sickLeaveDiagnosisCode")(e.target.value)
              }
              placeholder="Например: A15"
            />
          </div>
        </div>
      )}
    </InfoArticle>
  );
}
