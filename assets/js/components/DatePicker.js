// DatePicker.js
import React from 'react';

const DatePicker = ({ selectedDate, handleDateChange }) => (
  <div className="form-container">
    <form onSubmit={(e) => e.preventDefault()}>
      <label htmlFor="date">Select Date:</label>
      <input
        type="date"
        id="date"
        name="date"
        value={selectedDate}
        min="2023-01-01"
        max={new Date().toISOString().split('T')[0]}
        onChange={handleDateChange}
      />
    </form>
  </div>
);

export default DatePicker;
