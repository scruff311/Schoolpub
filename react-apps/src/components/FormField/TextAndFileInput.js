import React from 'react';
import { FormControl } from 'react-bootstrap';

const TextAndFileInput = props => {
  const fileStyle = {
    paddingTop: 7,
  };

  return (
    <FormControl
      type={props.type}
      placeholder={props.placeholder}
      onChange={event =>
        props.changed(event, props.dataHandle)
      }
      style={props.type === 'file' ? fileStyle : null}
    />
  );
};

export default TextAndFileInput;
