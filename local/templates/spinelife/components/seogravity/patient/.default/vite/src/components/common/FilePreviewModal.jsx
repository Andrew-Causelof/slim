import Modal from 'react-modal';

// Важно! Чтобы избежать проблем с доступностью
Modal.setAppElement('#react-lk-patient');

export default function FilePreviewModal({ file, onClose }) {
    if (!file) return null;

    const isImage = file.type === 'image';

    return (
        <Modal
            isOpen={!!file}
            onRequestClose={onClose}
            className="file-preview-modal"
            overlayClassName="file-preview-overlay"
        >
            <button className="file-preview-close" onClick={onClose}>X</button>
            {isImage ? (
                <img src={file.url} alt={file.name} className="file-preview-image" />
            ) : (
                <iframe
                    src={file.url}
                    className="file-preview-iframe"
                    frameBorder="0"
                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                    allowFullScreen
                />
            )}
        </Modal>
    );
}
