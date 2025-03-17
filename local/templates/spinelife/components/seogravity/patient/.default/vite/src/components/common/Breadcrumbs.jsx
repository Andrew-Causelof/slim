import PropTypes from 'prop-types';
import { useUserStore } from '../../store';

function Breadcrumbs({
  current = '',
}) {

  const { setUserData } = useUserStore();

  return (
    <div className="breadcrumbs">
      {/* @TODO какая главная страница ?  */}
      <a className="breadcrumbs_link" onClick={() => setUserData('activeTab', 'about')}>Личный кабинет</a>
      <span className="breadcrumbs_sep">/</span>
      <span className="breadcrumbs_text">{current}</span>
    </div>
  )
}

Breadcrumbs.propTypes = {
  current: PropTypes.string.isRequired
}

export default Breadcrumbs
