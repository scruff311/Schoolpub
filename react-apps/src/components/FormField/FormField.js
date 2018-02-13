import React, { Component } from 'react';
import {
  FormGroup,
  Alert,
  Col,
  ControlLabel,
  Popover,
  OverlayTrigger,
} from 'react-bootstrap';
import Aux from '../../hoc/Aux';
import TextAndFileInput from './TextAndFileInput';
import DropdownInput from './DropdownInput';
import RadioAndCheckboxGroup from './RadioAndCheckboxGroup';

class FormField extends Component {
  state = {
    error: false,
  };

  buildHelpPopover = (labelText) => {
    const popoverBody = this.props.help.map((helpItem, index) => {
      return (
        <Aux key={index}>
          <strong>{helpItem.title}</strong> {helpItem.text}
          {this.props.help.length !== index + 1 ? <br /> : null}
        </Aux>
      );
    });

    const popoverHover = (
      <Popover id="popover-trigger-hover" title={labelText}>
        {popoverBody}
      </Popover>
    );

    const helpIcon = (
      <OverlayTrigger
        trigger={['hover', 'focus']}
        placement="bottom"
        overlay={popoverHover}
      >
        <span className="glyphicon glyphicon-question-sign" />
      </OverlayTrigger>
    );
    return (
      <Aux>
        {labelText} {helpIcon}
      </Aux>
    );
  }

  render() {
    let control = null;
    if (this.props.type === 'text' || this.props.type === 'file') {
      control = (
        <TextAndFileInput
          type={this.props.type}
          placeholder={this.props.placeholder}
          changed={this.props.changed}
          dataHandle={this.props.dataHandle}
        />
      );
    } else if (this.props.type === 'select') {
      control = (
        <DropdownInput
          placeholder={this.props.placeholder}
          changed={this.props.changed}
          dataHandle={this.props.dataHandle}
          options={this.props.options}
        />
      );
    } else if (this.props.type === 'radio' || this.props.type === 'check') {
      control = (
        <RadioAndCheckboxGroup
          name={this.props.id}
          type={this.props.type}
          placeholder={this.props.placeholder}
          changed={this.props.changed}
          customFieldId={this.props.customFieldId}
          dataHandle={this.props.dataHandle}
          options={this.props.options}
          inline={this.props.inline}
        />
      );
    }

    let errorAlert = null;
    if (this.state.error && this.props.errorMsg) {
      errorAlert = (
        <Col smOffset={3}>
          <Alert bsStyle="danger">{this.props.errorMsg}</Alert>
        </Col>
      );
    }

    let label = this.props.labelText;
    if (this.props.help) {
      label = this.buildHelpPopover(label);
    }

    return (
      <Aux>
        <FormGroup controlId={this.props.id}>
          <Col componentClass={ControlLabel} sm={3}>
            {label}
          </Col>
          <Col sm={this.props.width}>{control}</Col>
        </FormGroup>
        {errorAlert}
      </Aux>
    );
  }
}

export default FormField;
