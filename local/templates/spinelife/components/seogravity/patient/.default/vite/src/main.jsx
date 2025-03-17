import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './assets/css/style.min.css'
import './assets/css/custom.css'
import App from './App.jsx'

createRoot(document.getElementById('react-lk-patient')).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
