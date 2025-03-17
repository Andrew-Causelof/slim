import React from 'react';
import { createRoot } from 'react-dom/client';
import AuthForm from './AuthForm';

createRoot(document.getElementById('react-auth')).render(<AuthForm />);