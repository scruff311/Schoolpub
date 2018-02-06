import React, { Component } from 'react';
import { Form, FormGroup, Button } from 'react-bootstrap';
import HorizontalInputForm from '../HorizontalInputForm/HorizontalInputForm';
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
      coverPrinting: [],
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
  };

  componentDidMount() {}

  handleInputChange = (event, id, type, stateParamName, option) => {
    let stateParam = { ...this.state[stateParamName] };
    // if an option is returned, this is a radio or checkbox
    if (type === 'check' || type === 'radio') {
      stateParam[id] = this.handleRadioOrCheckChange(
        event,
        type,
        stateParam[id],
        option,
      );
    } else {
      stateParam[id] =
        type === 'file' ? event.target.files[0] : event.target.value;
    }
    this.setState({
      [stateParamName]: stateParam,
    });
  };

  handleRadioOrCheckChange = (event, type, currentState, option) => {
    console.log(
      'currentState: ' + currentState,
      '\nvalue: ' + event.target.checked,
      '\noption: ' + option,
    );
    if (type === 'check') {
      // does the array already include this option?
      if (currentState.includes(option)) {
        const index = currentState.indexOf(option);
        // if the box is unchecked, remove the option
        if (!event.target.checked) {
          currentState.splice(index, 1);
        }
      }
      else {
        // the option is not in the array, add it
        if (event.target.checked) {
          currentState.push(option);
        }
      }
      return currentState;
    }
    return null;
  };

  render() {
    return (
      <div className={classes.LitMag}>
        <h1>Literary Magazine Order Form</h1>
        <HorizontalInputForm
          title="Publication Information"
          changed={this.handleInputChange}
          fields={publicationFields}
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
            <Button bsSize="large" type="submit" bsStyle="primary">
              Submit Order
            </Button>
          </FormGroup>
        </Form>
      </div>
    );
  }
}

export default LitMag;
