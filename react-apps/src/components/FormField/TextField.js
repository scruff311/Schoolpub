import React, { Component } from 'react';
import {
  FormGroup,
  FormControl,
  Alert,
  Col,
  ControlLabel,
} from 'react-bootstrap';
import Aux from '../../hoc/Aux';

class TextField extends Component {
  state = {
    error: false,
  };

  render() {
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
          <Col sm={9}>
            <FormControl
              type={this.props.type}
              placeholder={this.props.placeholder}
              onChange={event => this.props.changed(event, this.props.id)}
            />
          </Col>
        </FormGroup>
        {errorAlert}
      </Aux>
    );
  }
}

export default TextField;
