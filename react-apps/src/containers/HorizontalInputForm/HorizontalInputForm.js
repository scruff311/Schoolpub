import React from 'react';
import { Form } from 'react-bootstrap';
import FormField from '../../components/FormField/FormField';
import PriceDiv from '../../components/PriceDiv/PriceDiv';
import Aux from '../../hoc/Aux';
import classes from './HorizontalInputForm.css';

const horizontalInputForm = props => {
  const formFields = props.fields.map((field, index) => {
    return (
      <FormField
        key={index}
        id={field.id}
        labelText={field.label}
        type={field.type}
        options={field.options}
        width={field.width}
        changed={props.changed}
        errorMsg={field.error}
      />
    );
  });

  let header, footer, price = null;
  if (props.header) {
    header = <p className={classes.HeaderFooter}>{props.header}</p>;
  }
  if (props.footer) {
    footer = <p className={[classes.HeaderFooter, classes.Footer].join(' ')}>{props.footer}</p>;
  }
  if (props.price != null) {
    price = <PriceDiv labelText={props.price.label} price={props.price.value}/>
  }

  return (
    <Aux>
      <div className={classes.FormContainer}>
        <h3>{props.title}</h3>
        <Form horizontal className={classes.FormBody}>{[header, formFields, price, footer]}</Form>
      </div>
    </Aux>
  );
};

export default horizontalInputForm;
