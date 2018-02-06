import React from 'react';
import { FormControl } from 'react-bootstrap';

const dropdownInput = props => {
  return (
    <FormControl
      componentClass='select'
      placeholder={props.placeholder}
      onChange={event => props.changed(event, props.id, 'select', props.dataHandle)}
    >
      {props.options.map((option, index) => {
        return (
          <option key={index} value={option}>
            {option}
          </option>
        );
      })}
    </FormControl>
  );
};

export default dropdownInput;
