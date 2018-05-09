import React from 'react';
import ReactDOM from 'react-dom';
import LitMag from './containers/LitMag/LitMag';
import registerServiceWorker from './registerServiceWorker';
// import '../node_modules/bootstrap/dist/css/bootstrap.css';
import './index.css';

const rootContainers = {
	orderForm: 'react-lit-mag-container',
	pricing: 'react-lit-mag-pricing-container'
}

const doesContainerExist = id => {
  var element = document.getElementById(id);
  if (typeof element !== 'undefined' && element !== null) {
    return true;
  }
  return false;
};

for (const key in rootContainers) {
	let elementId = rootContainers[key]
	if (doesContainerExist(elementId)) {
		ReactDOM.render(
			<LitMag type={key} />,
			document.getElementById(elementId),
		);
	}
}

// let elementId = 'react-lit-mag-pricing-container'
// if (doesContainerExist(elementId)) {
//   ReactDOM.render(
//     <LitMag type="pricing" />,
//     document.getElementById(elementId),
//   );
// }

// elementId = 'react-lit-mag-container'
// if (doesContainerExist(elementId)) {
//   ReactDOM.render(
//     <LitMag type="order-form" />,
//     document.getElementById(elementId),
//   );
// }

// ReactDOM.render(
// 	<AnotherComponent />,
// 	document.getElementById('react-another-component-container')
// );

registerServiceWorker();
