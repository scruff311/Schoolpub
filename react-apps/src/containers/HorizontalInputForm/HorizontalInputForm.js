import React from 'react';
import { Form } from 'react-bootstrap';
import FormField from '../../components/FormField/FormField';
import Aux from '../../hoc/Aux';
import classes from '../LitMag/LitMag.css';

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

  return (
    <Aux>
      <div className={classes.FormContainer}>
        <h3>{props.title}</h3>
        <Form horizontal className={classes.FormBody}>{formFields}</Form>
      </div>
    </Aux>
  );
};

export default horizontalInputForm;
