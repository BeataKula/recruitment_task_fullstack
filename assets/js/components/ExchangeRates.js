// ExchangeRates.js
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useLocation, useHistory } from 'react-router-dom';
import DatePicker from './DatePicker';
import ExchangeRatesTable from './ExchangeRatesTable';
import LoadingSpinner from './LoadingSpinner';
import ErrorMessage from './ErrorMessage';

const ExchangeRates = () => {
  const [selectedDate, setSelectedDate] = useState(new Date().toISOString().split('T')[0]);
  const [todayDate, setTodayDate] = useState(new Date().toISOString().split('T')[0]);
  const [exchangeRates, setExchangeRates] = useState([]);
  const [todayRates, setTodayRates] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const location = useLocation();
  const history = useHistory();

  useEffect(() => {
    const queryParams = new URLSearchParams(location.search);
    const dateFromUrl = queryParams.get('date');
    if (dateFromUrl) {
      setSelectedDate(dateFromUrl);
    }
  }, [location.search]);

  useEffect(() => {
    fetchExchangeRates(selectedDate, setExchangeRates);
    fetchExchangeRates(todayDate, setTodayRates);
  }, [selectedDate, todayDate]);

  const handleDateChange = (e) => {
    const newDate = e.target.value;
    setSelectedDate(newDate);
    history.push(`/exchange-rates?date=${newDate}`);
  };

  const fetchExchangeRates = async (date, setRates) => {
      setLoading(true);
      setError(null);
    try {
      const response = await axios.get(`/api/exchange-rates?date=${date}`);
      setRates(Object.values(response.data.currencyDTOCollection.currencies));
    } catch (error) {
      if (error.response && error.response.data && error.response.data.error) {
        setError(error.response.data.error);
      } else {
        setError('Error fetching exchange rates');
      }
    } finally {
        setLoading(false);
    }
  };

  return (
    <div className="exchange-rates-container">
      <h1>Exchange Rates</h1>

      <header className="header-container">
        <div className="header__left">
          <h3>Rates for {selectedDate}</h3>
        </div>
        <div className="header__right">
          <h3>Today's Rates ({todayDate})</h3>
        </div>
      </header>

      <DatePicker selectedDate={selectedDate} handleDateChange={handleDateChange} />
      {loading && <LoadingSpinner />}
      {error && <ErrorMessage message={error} />}

      {!loading && !error && (
        <ExchangeRatesTable
          exchangeRates={exchangeRates}
          todayRates={todayRates}
          selectedDate={selectedDate}
          todayDate={todayDate}
        />
      )}
    </div>
  );
};

export default ExchangeRates;
