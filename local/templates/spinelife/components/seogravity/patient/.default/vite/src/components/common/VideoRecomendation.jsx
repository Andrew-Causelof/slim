import PropTypes from 'prop-types'

export default function VideoRecomendation({ img, url, title }) {
  return (
    <div className="video_item">
      <div className="video_item_img">
        <img src={img} alt={title} />
        <a className="video_item_play" href={url}></a>
      </div>
      <div className="video_item_title"> {title}</div>
    </div>
  )
}

VideoRecomendation.propTypes = {
  img: PropTypes.string.isRequired,
  url: PropTypes.string.isRequired,
  title: PropTypes.string.isRequired
}

