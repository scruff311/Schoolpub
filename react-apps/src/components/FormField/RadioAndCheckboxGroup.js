import React from 'react';
import { Checkbox, Radio } from 'react-bootstrap';
import Aux from '../../hoc/Aux';

const radioAndCheckboxGroup = props => {
  return props.options.map((option, index) => {
    if (props.type === 'check') {
      return (
        <Aux key={index}>
          <Checkbox
            inline={props.inline}
            onChange={event =>
              props.changed(
                event,
                props.id,
                props.type,
                props.dataHandle,
                option,
              )
            }
          >
            {option}
          </Checkbox>{' '}
        </Aux>
      );
    }

    return null;
  });
};

export default radioAndCheckboxGroup;
