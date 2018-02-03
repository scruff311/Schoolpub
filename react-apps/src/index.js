import React from 'react';
import ReactDOM from 'react-dom';
import LitMag from './containers/LitMag/LitMag';
import registerServiceWorker from './registerServiceWorker';
// import '../node_modules/bootstrap/dist/css/bootstrap.css';
import './index.css';

ReactDOM.render(
	<LitMag />,
	document.getElementById('react-lit-mag-container')
);

// ReactDOM.render(
// 	<AnotherComponent />,
// 	document.getElementById('react-another-component-container')
// );

registerServiceWorker();
