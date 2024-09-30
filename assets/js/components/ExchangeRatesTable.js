// ExchangeRatesTable.js
import React from 'react';

const formatRate = (rate) => {
  return Number.isFinite(rate) ? rate.toFixed(4) : 'N/A';
};

const ExchangeRatesTable = ({ exchangeRates, todayRates, selectedDate, todayDate }) => (
  <div className="grid-container">
    <div className="grid-header">
      <div>Currency Code</div>
      <div>NBP Rate <span>{selectedDate}</span></div>
      <div className="light-th-cell">NBP Rate <span>Today: {todayDate}</span></div>
      <div>Buy Rate <span>{selectedDate}</span></div>
      <div className="light-th-cell">Buy Rate <span>Today: {todayDate}</span></div>
      <div>Sell Rate <span>{selectedDate}</span></div>
      <div className="light-th-cell">Sell Rate <span>Today: {todayDate}</span></div>
    </div>
    <div className="grid-content">
      {exchangeRates.map((rate) => {
        const todayRate = todayRates.find(todayRate => todayRate.currencyCode === rate.currencyCode) || {};

        return (
          <div key={rate.currencyCode} className="grid-row">
            <div className="th-cell">{rate.currencyCode} <span>{rate.currencyName}</span> </div>
            <div>{formatRate(rate.nbpRate)}</div>
            <div className="light-cell">{formatRate(todayRate?.nbpRate)}</div>
            <div>{formatRate(rate.buyRate)}</div>
            <div className="light-cell">{formatRate(todayRate?.buyRate)}</div>
            <div>{formatRate(rate.sellRate)}</div>
            <div className="light-cell">{formatRate(todayRate?.sellRate)}</div>
          </div>
        );
      })}
    </div>
  </div>
);

export default ExchangeRatesTable;
