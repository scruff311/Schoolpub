import React from 'react';
import { Col } from 'react-bootstrap';
import numeral from 'numeral';
import classes from './PriceDiv.css';

const priceDiv = props => {
  return (
    <div className={[classes.Price, 'bg-primary', 'text-white'].join(' ')}>
        <Col sm={5}>
          {props.labelText}
        </Col>
        <Col sm={7}>{numeral(props.price).format('$0,0.00')}</Col>
    </div>
  );
};

export default priceDiv;
