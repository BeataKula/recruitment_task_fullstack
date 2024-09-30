// ExchangeRatesTable.js
import React from 'react';
import FormatRate from './Formatter.js';
import '../../css/echangeRatesTable.css';



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
            <div>{FormatRate(rate.referenceRate)}</div>
            <div className="light-cell">{FormatRate(todayRate?.referenceRate)}</div>
            <div>{FormatRate(rate.buyRate)}</div>
            <div className="light-cell">{FormatRate(todayRate?.buyRate)}</div>
            <div>{FormatRate(rate.sellRate)}</div>
            <div className="light-cell">{FormatRate(todayRate?.sellRate)}</div>
          </div>
        );
      })}
    </div>
  </div>
);

export default ExchangeRatesTable;
