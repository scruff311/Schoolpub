import React from 'react';
import ReactDOM from 'react-dom';
import LitMag from './containers/LitMag/LitMag';
import registerServiceWorker from './registerServiceWorker';
// import '../node_modules/bootstrap/dist/css/bootstrap.css';
import './index.css';

ReactDOM.render(
	<LitMag type='order-form'/>,
	document.getElementById('react-lit-mag-container')
);

ReactDOM.render(
	<LitMag type='pricing'/>,
	document.getElementById('react-lit-mag-pricing-container')
);

// ReactDOM.render(
// 	<AnotherComponent />,
// 	document.getElementById('react-another-component-container')
// );

registerServiceWorker();
