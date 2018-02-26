import React from 'react';
import { Checkbox, Radio } from 'react-bootstrap';
import CustomValueRadio from './CustomValueRadio';
import Aux from '../../hoc/Aux';

const radioAndCheckboxGroup = props => {
	const style = {
		marginBottom: 7
	}

  return props.options.map((option, index) => {
    if (props.type === 'check') {
      return (
        <Aux key={props.name + index}>
          <Checkbox
            name={props.name}
            value={option}
            inline={props.inline}
						onChange={event => props.changed(event, props.dataHandle)}
						style={style}
          >
            {option}
          </Checkbox>{' '}
        </Aux>
      );
    } else if (props.type === 'radio') {
      let child = option;
      if (option === 'Other') {
        child = (
          <CustomValueRadio
            id={props.customFieldId}
            placeholder={props.placeholder}
						changed={props.changed}
            dataHandle={props.dataHandle}
          />
        );
      }

      return (
        <Aux key={props.name + index}>
          <Radio
            name={props.name}
            value={option}
            inline={props.inline}
            onChange={event => props.changed(event, props.dataHandle)}
            checked={option === props.selectedOption}
						style={style}
          >
            {child}
          </Radio>{' '}
        </Aux>
      );
    }

    return null;
  });
};

export default radioAndCheckboxGroup;
