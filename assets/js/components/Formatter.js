
// ExchangeRatesTable.js
const FormatRate = (rate) => {
    return Number.isFinite(rate) ? rate.toFixed(4) : 'N/A';
  };

export default FormatRate;