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
import DropdownAndTextAreaInput from './DropdownAndTextAreaInput';
import RadioAndCheckboxGroup from './RadioAndCheckboxGroup';

class FormField extends Component {
  buildHelpPopover = labelText => {
    let popoverCharCount = 0;
    const popoverBody = this.props.help.map((helpItem, index) => {
      // we keep track of the amount of help text for each popover incase we need to adjust the styling
      popoverCharCount =
        popoverCharCount + helpItem.title.length + helpItem.text.length;
        
      return (
        <Aux key={index}>
          <strong>{helpItem.title}</strong> {helpItem.text} <br />
          {this.props.help.length !== index + 1 ? <br /> : null}
        </Aux>
      );
    });

    const popStyle = {
      maxWidth: 550,
    };

    const popoverHover = (
      <Popover
        id="popover-trigger-hover"
        title={labelText}
        style={popoverCharCount > 300 ? popStyle : null}
      >
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
  };

  render() {
    let control = null;
    if (this.props.type === 'select'|| this.props.type === 'textarea') {
      control = (
        <DropdownAndTextAreaInput
          type={this.props.type}
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
          selectedOption={this.props.selectedOption}
          inline={this.props.inline}
        />
      );
    }
    else {
      control = (
        <TextAndFileInput
          type={this.props.type}
          placeholder={this.props.placeholder}
          changed={this.props.changed}
          dataHandle={this.props.dataHandle}
        />
      );
    }

    let errorAlert = null;
    if (this.props.error && this.props.errorMsg) {
      errorAlert = (
        <Col smOffset={3}>
          <Alert bsStyle="danger">{this.props.errorMsg}</Alert>
        </Col>
      );
    }

    let successAlert = null;
    if (this.props.success && this.props.successMsg) {
      successAlert = (
        <Col smOffset={3}>
          <Alert bsStyle="success">{this.props.successMsg}</Alert>
        </Col>
      );
    }

    let label = this.props.labelText;
    if (this.props.help) {
      label = this.buildHelpPopover(label);
    }

    return (
      <Aux>
        {successAlert}
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
