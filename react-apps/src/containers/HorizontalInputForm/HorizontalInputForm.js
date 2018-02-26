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
        key={field.id}
        id={field.id}
        labelText={field.label}
        placeholder={field.placeholder}
        type={field.type}
        dataHandle={props.stateData}
        options={field.options}
        selectedOption={field.selectedOption}
        width={field.width}
        inline={field.inline}
        changed={props.changed}
        customFieldId={field.customFieldId}
        errorMsg={field.errorMsg}
        help={field.help}
      />
    );
  });

  let header,
    footer,
    price = null;
  if (props.header) {
    header = (
      <p key={props.stateData + '_header'} className={classes.HeaderFooter}>
        {props.header}
      </p>
    );
  }
  if (props.footer) {
    footer = (
      <p
        key={props.stateData + '_footer'}
        className={[classes.HeaderFooter, classes.Footer].join(' ')}
      >
        {props.footer}
      </p>
    );
  }
  if (props.price != null) {
    price = (
      <PriceDiv
        key={props.stateData + '_price'}
        labelText={props.price.label}
        price={props.price.value}
      />
    );
  }

  return (
    <Aux>
      <div className={classes.FormContainer}>
        <h3>{props.title}</h3>
        <Form horizontal className={classes.FormBody}>
          {[header, formFields, price, footer]}
        </Form>
      </div>
    </Aux>
  );
};

export default horizontalInputForm;
