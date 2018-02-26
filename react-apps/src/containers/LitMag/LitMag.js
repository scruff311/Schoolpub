import React, { Component } from 'react';
import { Form, FormGroup, Button, Checkbox } from 'react-bootstrap';
import HorizontalFormSection from '../HorizontalFormSection/HorizontalFormSection';
import _ from 'lodash';
import { updateLitMagPrice } from '../../assets/js/new_prices';
import classes from './LitMag.css';
import {
  publicationFields,
  priceFields,
  schoolInfoFields,
  fileFields,
} from '../../data/LitMagFormFields';

const pagesToColor = {
  id: 'pagesToColor',
  label: 'Which Pages in Color',
  placeholder: 'Example: 1, 3-6, 10, 12',
  type: 'text',
  options: null,
  width: 4,
  error: 'Please indicate which pages you would like to be in color.',
  inline: null,
};

class LitMag extends Component {
  state = {
    pubInfo: {
      name: '',
      dimensions: '',
      customDimensions: '', //if dimensions = 'Other', we use this field
      copies: '',
      insidePages: '',
      colorPages: '',
      pagesToColor: '',
      paperStock: '',
      coverStyle: '',
      coverPrinting: [],
      binding: '',
    },
    price: {
      promo: '',
      total: 0,
    },
    schoolInfo: {
      name: '',
      advisorName: '',
      address: '',
      city: '',
      state: '',
      zip: '',
      phone: '',
      email: '',
    },
    files: {
      file1: null,
      file2: null,
      file3: null,
    },
    publicationFields: publicationFields,
    priceQuoteToggle: false,
  };

  componentDidMount() {
    console.log('componentDidMount');
    this.populateDropdownOptions('publicationFields', 'copies', 25, 1000, 25);
    this.populateDropdownOptions(
      'publicationFields',
      'insidePages',
      12,
      160,
      4,
    );
    this.populateDropdownOptions('publicationFields', 'colorPages', 0, 12, 1);
    // set initial defaults on page load
    let pubState = { ...this.state.pubInfo };
    pubState = {
      ...pubState,
      dimensions: '8.5 x 11',
      copies: '25',
      insidePages: '12',
      colorPages: '0',
      paperStock: 'Offset',
      coverStyle: 'Self-Cover',
      binding: 'Saddle Stitched',
    };
    this.setState({
      pubInfo: pubState,
    });
  }

  componentDidUpdate(prevProps, prevState) {
    // udpate the price total using the new pubInfo or promo code
    if (
      prevState.pubInfo !== this.state.pubInfo ||
      prevState.price.promo !== this.state.price.promo
    ) {
      const updatedPrice = updateLitMagPrice(
        this.state.pubInfo,
        this.state.price,
      );
      // when these fields change we update the price. doing this here prevents an infinite loop
      let price = { ...this.state.price };
      price.total = updatedPrice;
      this.setState({
        price,
      });
    }
  }

  getFieldData = (fields, fieldId) => {
    // find the field object with the given id
    let fieldData = fields.find(element => {
      return element.id === fieldId;
    });
    return fieldData;
  };

  handleInputChange = (event, stateParamName) => {
    /* first we set the new state data that will be used for the order */
    let stateParam = { ...this.state[stateParamName] };
    const target = event.target;
    const identifier =
      target.type === 'checkbox' || target.type === 'radio'
        ? target.name
        : target.id;
    // a checkbox could have an array of values, so we need to handle this separately
    if (target.type === 'checkbox') {
      stateParam[identifier] = this.handleCheckboxChange(
        target,
        stateParam[identifier],
      );
    } else {
      stateParam[identifier] =
        target.type === 'file' ? target.files[0] : target.value;
    }
    this.setState({
      [stateParamName]: stateParam,
    });

    /* now we update the form props if needed so they render correctly */
    // when a radio button is changed, we need to change the selectedOption prop
    if (target.type === 'radio') {
      this.handleRadioChange('publicationFields', identifier, target.value);
    }

    // when we change the number of pages, we need to update the # color pages dropdown
    if (identifier === 'insidePages') {
      this.populateDropdownOptions(
        'publicationFields',
        'colorPages',
        0,
        parseInt(target.value),
        1,
      );
    }

    // we need to display/hide the field for specifying which pages are in color
    if (identifier === 'colorPages') {
      this.toggleDependentField(
        'publicationFields',
        'colorPages',
        pagesToColor,
        parseInt(target.value),
      );
    }
  };

  handleCheckboxChange = (target, currentState) => {
    if (target.type === 'checkbox') {
      // does the array already include this option?
      if (currentState.includes(target.value)) {
        const index = currentState.indexOf(target.value);
        // if the box is unchecked, remove the option
        if (!target.checked) {
          currentState.splice(index, 1);
        }
      } else {
        // the option is not in the array, add it
        if (target.checked) {
          currentState.push(target.value);
        }
      }
      return currentState;
    }
    return null;
  };

  handleRadioChange = (stateKey, fieldId, selectedOption) => {
    let fields = [...this.state[stateKey]];
    let fieldData = this.getFieldData(fields, fieldId);
    // if we found the object, assign the selected option prop
    if (fieldData) {
      fieldData.selectedOption = selectedOption;
      this.updateFormField(stateKey, fields, fieldData);
    }
  };

  handleSubmit = (e) => {
    e.preventDefault();
    alert('Your order has been submitted!');
  };

  populateDropdownOptions = (stateKey, fieldId, min, max, step) => {
    let fields = [...this.state[stateKey]];
    let fieldData = this.getFieldData(fields, fieldId);
    // if we found the object, create the array and apply it
    if (fieldData) {
      // create the array, starting with min, going to max by the specified step
      fieldData.options = _.range(min, max + step, step);
      this.updateFormField(stateKey, fields, fieldData);
    }
  };

  toggleDependentField = (stateKey, parentFieldId, childField, parentValue) => {
    let fields = [...this.state[stateKey]];
    let childIndex = fields.findIndex(element => {
      return element.id === childField.id;
    });

    if (childIndex === -1) {
      // child does not appear in the state
      if (parentValue > 0) {
        // > 0, show the child field
        const parentIndex = fields.findIndex(element => {
          return element.id === parentFieldId;
        });
        if (parentIndex !== -1) {
          fields.splice(parentIndex + 1, 0, childField); // add it just after the parent field
        }
      }
    } else if (parentValue === 0) {
      // child is present but parent = 0, remove the child field
      fields.splice(childIndex, 1);
    }
    this.setState({
      [stateKey]: fields,
    });
  };

  updateFormField = (stateKey, fields, fieldData) => {
    const fieldIndex = fields.indexOf(fieldData);
    fields[fieldIndex] = fieldData;
    this.setState({
      [stateKey]: fields,
    });
  };

  render() {
    const title =
      this.props.type === 'order-form'
        ? 'Literary Magazine Order Form'
        : 'Literary Magazine Pricing';

    const priceQuoteToggle = (
      <Checkbox
        name="priceQuoteToggle"
        onChange={() => {
          let toggleState = this.state.priceQuoteToggle;
          this.setState({
            priceQuoteToggle: !toggleState,
          });
        }}
      >
        Submit for Formal Quote from SPC
      </Checkbox>
    );

    const schoolInfoForm = (
      <HorizontalFormSection
        title="School Information"
        changed={this.handleInputChange}
        fields={schoolInfoFields}
        stateData="schoolInfo"
      />
    );

    const fileUploadForm = (
      <HorizontalFormSection
        title="File Upload"
        changed={this.handleInputChange}
        fields={fileFields}
        stateData="files"
        header="You may wish to compress your files to save transmission time. Files may be compressed as .zip or .sit files. PC users can use WinZip to create .zip files; Mac users should use Stuffit to create either .sit files or .zip (preferred) archives to prevent file corruption."
        footer={[
          'MAXIMUM FILE SIZE IS 64 MB!',
          <br key="break2" />,
          'Files larger than 64 Mb will be rejected by the server! If you attach multiple files, the combined size can be no more than 64 MB. Call us if you need assistance.',
        ]}
      />
    );

    const submitButton = (
      <FormGroup className="text-center">
        <Button bsSize="large" bsStyle="primary" type="submit">
          {this.props.type === 'order-form'
            ? 'Submit Order'
            : 'Submit for Quote'}
        </Button>
      </FormGroup>
    );

    return (
      <div className={classes.LitMag}>
        <h1>{title}</h1>
        {this.props.type === 'pricing' ? (
          <h4 style={{ marginTop: 30, color: '#777' }}>
            SPC has the lowest magazine prices in the industry and the fastest
            production time, with just a 5 business day turnaround (plus
            shipping time).
          </h4>
        ) : null}
        <Form horizontal onSubmit={this.handleSubmit}>
          <HorizontalFormSection
            title="Publication Information"
            changed={this.handleInputChange}
            fields={this.state.publicationFields}
            stateData="pubInfo"
            header="The options below are based on standard orders. If you are looking for a different paper stock, special size, or any other custom option please call our office to speak with us directly."
          />
          <HorizontalFormSection
            title="Pricing"
            changed={this.handleInputChange}
            fields={priceFields}
            stateData="price"
            price={{
              label: 'Total:',
              value: this.state.price.total,
            }}
            footer={[
              'Ground shipping is included in the price.',
              <br key="break1" />,
              'If you need expedited shipping, please contact our office for pricing.',
            ]}
          />
          {this.props.type === 'pricing' ? priceQuoteToggle : null}
          {this.props.type === 'order-form' || this.state.priceQuoteToggle
            ? schoolInfoForm
            : null}
          {this.props.type === 'order-form' ? fileUploadForm : null}
          {this.props.type === 'order-form' || this.state.priceQuoteToggle
            ? submitButton
            : null}
        </Form>
      </div>
    );
  }
}

export default LitMag;
