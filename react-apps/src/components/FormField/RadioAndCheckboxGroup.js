import React from 'react';
import { Checkbox, Radio } from 'react-bootstrap';
import Aux from '../../hoc/Aux';

const radioAndCheckboxGroup = props => {
  return props.options.map((option, index) => {
    if (props.type === 'check') {
      return (
        <Aux key={index}>
					<Checkbox
						name={props.name}
						value={option}
            inline={props.inline}
            onChange={event =>
              props.changed(
                event,
                props.dataHandle,
                option,
              )
            }
          >
            {option}
          </Checkbox>{' '}
        </Aux>
      );
    } else if (props.type === 'radio') {
			return (
        <Aux key={index}>
					<Radio
						name={props.name}
						value={option}
            inline={props.inline}
            onChange={event =>
              props.changed(
                event,
                props.dataHandle,
                option,
              )
            }
          >
            {option}
          </Radio>{' '}
        </Aux>
      );
		}

    return null;
  });
};

export default radioAndCheckboxGroup;
