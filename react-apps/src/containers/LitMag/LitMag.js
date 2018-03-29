import React, { Component } from 'react';
import { Form, FormGroup, Button, Checkbox, Alert } from 'react-bootstrap';
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
  required: true,
  error: false,
  errorMsg: 'Please indicate which pages you would like to be in color.',
  inline: null,
};

// this is a simple mapping of which state params correspond to which fields
const formToStateMap = {
  publicationFields: 'pubInfo',
  priceFields: 'price',
  schoolInfoFields: 'schoolInfo',
  fileFields: 'files',
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
      pagesToColor: 'None',
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
    priceFields: priceFields,
    schoolInfoFields: schoolInfoFields,
    fileFields: fileFields,
    priceQuoteToggle: false,
    submitStatus: null,
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
      // let paramArray = stateParam[identifier];
      // if (paramArray === null) {
      //   paramArray = [];
      // }
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
    let formSection = [...this.state[stateKey]];
    let fieldData = this.getFieldData(formSection, fieldId);
    // if we found the object, assign the selected option prop
    if (fieldData) {
      fieldData.selectedOption = selectedOption;
      this.updateFormField(stateKey, formSection, fieldData);
    }
  };

  handleSubmitOrder = e => {
    e.preventDefault();
    let isFormInvalid = Object.keys(formToStateMap).some(key => {
      let formSection = this.state[key];
      let stateParam = this.state[formToStateMap[key]];
      return !this.validateForm(key, formSection, stateParam);
    });

    if (isFormInvalid) {
      alert('Please correct the form errors.');
    } else {
      this.postFormToServer();
    }
  };

  postFormToServer = () => {
    const data = this.parseStateIntoJson();
    let header = new Headers({
      'Access-Control-Allow-Origin': '*',
      'Content-Type': 'multipart/form-data',
    });

    // fetch('http://www.schoolpub.com/lit-mag-submit.php', {
    fetch('http://localhost:8888/schoolpub/lit-mag-submit.php', {
      method: 'POST',
      mode: 'cors',
      header: header,
      body: data,
    })
      .then(res => {
        return res.json();
      })
      .then(data => {
        console.log('Request successful: ', data.response);
        this.setState({
          submitStatus: data.response === 1 ? true : false,
        })
      })
      .catch(err => {
        console.log('fetch error: ', err);
      });
  }

  parseStateIntoJson = () => {
    // const { files } = this.state;
    // send state data to submit script
    let data = new FormData();
    // for (const fileKey in files) {
    //   data.append(fileKey, files[fileKey]);
    // }
    for (const formKey in formToStateMap) {
      const stateKey = formToStateMap[formKey];
      const stateData = this.state[stateKey];
      for (const subKey in stateData) {
        const postKey = stateKey + '_' + subKey;
        data.append(postKey, stateData[subKey]);
      }
    }

    return data;
  };

  isFieldEmpty = field => {
    return (
      field === '' ||
      field === null ||
      (Array.isArray(field) && field.length === 0)
    );
  };

  populateDropdownOptions = (stateKey, fieldId, min, max, step) => {
    let formSection = [...this.state[stateKey]];
    let fieldData = this.getFieldData(formSection, fieldId);
    // if we found the object, create the array and apply it
    if (fieldData) {
      // create the array, starting with min, going to max by the specified step
      fieldData.options = _.range(min, max + step, step);
      this.updateFormField(stateKey, formSection, fieldData);
    }
  };

  getSubmitAlert = () => {
    const { submitStatus } = this.state;
    if (submitStatus == null) {
      return null;
    }

    let type, message;
    if (submitStatus === true) {
      type = 'success';
      message =
        'Your order is submitted! Check your email for additional instructions.';
    } else {
      type = 'danger';
      message =
        'Oops! A problem has occured. Please call our office for assistance.';
    }

    return <Alert bsStyle={type}>{message}</Alert>;
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

  updateFormField = (stateKey, formSection, fieldData) => {
    const fieldIndex = formSection.indexOf(fieldData);
    formSection[fieldIndex] = fieldData;
    this.setState({
      [stateKey]: formSection,
    });
  };

  validateForm = (stateKey, formSection, stateParam) => {
    // go through each field. if it is required and the corresponding state is empty, return false (invalid)
    let invalidForm = formSection.some(field => {
      if (field.required && this.isFieldEmpty(stateParam[field.id])) {
        field.error = true;
      } else if (
        field.required &&
        field.id === 'email' &&
        !stateParam[field.id].match(/\S+@\S+\.\S+/)
      ) {
        field.error = true;
      } else if (
        field.required &&
        field.id === 'zip' &&
        !stateParam[field.id].match(/^[0-9]{5}(?:-[0-9]{4})?$/)
      ) {
        field.error = true;
      } else {
        field.error = false;
      }
      this.updateFormField(stateKey, formSection, field);
      return field.error;
    });
    return !invalidForm;
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
        fields={this.state.schoolInfoFields}
        stateData="schoolInfo"
      />
    );

    const fileUploadForm = (
      <HorizontalFormSection
        title="File Upload"
        changed={this.handleInputChange}
        fields={this.state.fileFields}
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
        <div className={classes.SubmitDiv}>
          {this.getSubmitAlert()}
          <Button bsSize="large" bsStyle="primary" type="submit">
            {this.props.type === 'order-form'
              ? 'Submit Order'
              : 'Submit for Quote'}
          </Button>
        </div>
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
        <Form horizontal onSubmit={this.handleSubmitOrder}>
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
            fields={this.state.priceFields}
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
