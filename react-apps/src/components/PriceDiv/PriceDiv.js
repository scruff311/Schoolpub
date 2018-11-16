import React from 'react';
import { Grid, Col, Row } from 'react-bootstrap';
import numeral from 'numeral';
import classes from './PriceDiv.css';

const priceDiv = props => {
  let originalPrice = null;
  if (props.price !== props.original) {
    originalPrice = (
      <Row>
        <Col sm={5}>Original:</Col>
        <Col sm={7}>{numeral(props.original).format('$0,0.00')}</Col>
      </Row>
    );
  }

  return (
    <div className={[classes.Price, 'bg-primary', 'text-white'].join(' ')}>
      <Grid>
        <Row>
          <Col sm={5} className={classes.Total}>{props.labelText}</Col>
          <Col sm={7} className={classes.Total}>{numeral(props.price).format('$0,0.00')}</Col>
        </Row>
        {originalPrice}
      </Grid>
    </div>
  );
};

export default priceDiv;
