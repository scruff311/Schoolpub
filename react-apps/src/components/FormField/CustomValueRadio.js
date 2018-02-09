import React from 'react';

const customValueRadio = props => {	
	const labelStyle = {
		paddingLeft: 0
	};

	const inputStyle = {
		marginLeft: 7,
		padding: '6px 12px',
		border: '1px solid #ccc',
		borderRadius: '4px',
		color: '#555'
	}

  return (
    <div style={{ marginTop: -6 }}>
      <label style={labelStyle}>
        Other
        <input
          type="text"
          id={props.id}
					placeholder={props.placeholder}
					style={inputStyle}
					onChange={event => props.changed(event, props.dataHandle)}
        />
      </label>
    </div>
  );
};

export default customValueRadio;
