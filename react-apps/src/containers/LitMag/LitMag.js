import React, { Component } from 'react';
import { Form, FormGroup, Button } from 'react-bootstrap';
import HorizontalInputForm from '../HorizontalInputForm/HorizontalInputForm';
import _ from 'lodash';
import classes from './LitMag.css';
import {
  publicationFields,
  priceFields,
  schoolInfoFields,
  fileFields,
} from '../../data/LitMagFormFields';

class LitMag extends Component {
  state = {
    pubInfo: {
      name: '',
      dimensions: '',
      customDimensions: '', //if dimensions = 'Other', we use this field
      paperStock: '',
      coverStock: '',
      coverPrinting: [],
      binding: '',
    },
    price: {
      promo: '',
      total: 1000.33333,
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
  };

  componentDidMount() {
    console.log('componentDidMount');
    this.populateDropdownOptions('publicationFields', 'insidePages', 12, 160, 4);
    this.populateDropdownOptions('publicationFields', 'colorPages', 0, 12, 1);
  }

  handleInputChange = (event, stateParamName) => {
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

    // when we change the number of pages, we need to update the # color pages dropdown
    if (identifier === 'insidePages') {
      this.populateDropdownOptions('publicationFields', 'colorPages', 0, parseInt(target.value), 1);
    }

    console.log('')
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

  populateDropdownOptions = (fieldsKey, fieldId, min, max, step) => {
    // find the field object with the given id
    let fields = [ ...this.state[fieldsKey] ];
    let fieldData = fields.find(element => {
      return element.id === fieldId;
    });
    // if we found the object, create the array and apply it
    if (fieldData) {
      // create the array, starting with min, going to max by the specified step
      fieldData.options = _.range(min, max+step, step);
      const fieldIndex = fields.indexOf(fieldData);
      fields[fieldIndex] = fieldData;
      this.setState({
        [fieldsKey]: fields,
      });
    }
  }

  // setCustomRadioRef = (ref) => {
  //   this.customDimensionRef = ref;
  // };

  render() {
    console.log('render()');
    return (
      <div className={classes.LitMag}>
        <h1>Literary Magazine Order Form</h1>
        <HorizontalInputForm
          title="Publication Information"
          changed={this.handleInputChange}
          fields={this.state.publicationFields}
          stateData="pubInfo"
        />
        <HorizontalInputForm
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
        <HorizontalInputForm
          title="School Information"
          changed={this.handleInputChange}
          fields={schoolInfoFields}
          stateData="schoolInfo"
        />
        <HorizontalInputForm
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
        <Form horizontal>
          <FormGroup className="text-center">
            <Button bsSize="large" bsStyle="primary" onClick={this.populateDropdownOptions}>
              Submit Order
            </Button>
          </FormGroup>
        </Form>
      </div>
    );
  }
}

export default LitMag;
