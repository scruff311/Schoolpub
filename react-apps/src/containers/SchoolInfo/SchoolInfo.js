import React from 'react';
import { Form } from 'react-bootstrap';
import TextField from '../../components/FormField/TextField';
import classes from '../LitMag/LitMag.css';

const schoolInfo = props => {
  return (
    <div className={classes.FormContainer}>
      <Form horizontal>
        <TextField
          id="name"
          labelText="School Name"
          type="text"
          changed={props.changed}
          errorMsg="Please provide a school name."
        />
        <TextField
          id="advisorName"
          labelText="Advisor Name"
          type="text"
          changed={props.changed}
          errorMsg="Please provide an advisor name."
        />
      </Form>
    </div>
  );
};

export default schoolInfo;
