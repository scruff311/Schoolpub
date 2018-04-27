import React from 'react';
import { FormControl } from 'react-bootstrap';

const dropdownAndTextAreaInput = props => {

  let dropdownOptions = null;
  if (props.type === 'select') {
    dropdownOptions = props.options.map((option, index) => {
      return (
        <option key={index} value={option}>
          {option}
        </option>
      );
    });
  }

  return (
    <FormControl
      componentClass={props.type}
      placeholder={props.placeholder}
      onChange={event => props.changed(event, props.dataHandle)}
    >
      {dropdownOptions}
    </FormControl>
  );
};

export default dropdownAndTextAreaInput;
