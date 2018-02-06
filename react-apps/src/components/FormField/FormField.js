import React, { Component } from 'react';
import {
  FormGroup,
  FormControl,
  Alert,
  Col,
  ControlLabel,
} from 'react-bootstrap';
import Aux from '../../hoc/Aux';

class FormField extends Component {
  state = {
    error: false,
  };

  render() {
    let control = null;
    if (this.props.type === 'text') {
      control = (
        <FormControl
          type={this.props.type}
          placeholder={this.props.placeholder}
          onChange={event => this.props.changed(event, this.props.id)}
        />
      );
    } else if (this.props.type === 'select') {
      control = (
        <FormControl
          componentClass={this.props.type}
          placeholder={this.props.placeholder}
          onChange={event => this.props.changed(event, this.props.id)}
        >
          {this.props.options.map((option, index) => {
            return (
              <option key={index} value={option}>
                {option}
              </option>
            );
          })}
        </FormControl>
      );
    }

    let errorAlert = null;
    if (this.state.error) {
      errorAlert = (
        <Col smOffset={3}>
          <Alert bsStyle="danger">{this.props.errorMsg}</Alert>
        </Col>
      );
    }

    return (
      <Aux>
        <FormGroup controlId={this.props.id}>
          <Col componentClass={ControlLabel} sm={3}>
            {this.props.labelText}
          </Col>
          <Col sm={this.props.width}>
            {control}
          </Col>
        </FormGroup>
        {errorAlert}
      </Aux>
    );
  }
}

export default FormField;
