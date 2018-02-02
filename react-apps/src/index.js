import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import LitMag from './containers/LitMag/LitMag';
import registerServiceWorker from './registerServiceWorker';

ReactDOM.render(
	<LitMag />,
	document.getElementById('react-lit-mag-container')
);

// ReactDOM.render(
// 	<AnotherComponent />,
// 	document.getElementById('react-another-component-container')
// );

registerServiceWorker();
