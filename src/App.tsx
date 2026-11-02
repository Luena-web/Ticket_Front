import React from 'react'
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom' // ◄--- Importations complétées
import Login from './Components/Login'
import Authentification from './Components/Authentification'


import CreateTicket from './Components/TicketForm'
import Dashboard  from './Components/Dashboard'

const App = () => {
  return (
      <div>
        <Routes>

          <Route path="/login" element={<Login />} />
          <Route path="/ticket" element={<CreateTicket />} />
          <Route path="/dashboard" element={<Dashboard />} />
          <Route path="/Auth" element={<Authentification />} />



        </Routes>
      </div>
    
  )
}

export default App
