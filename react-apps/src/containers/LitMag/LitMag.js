import React, { Component } from 'react';
import { Form, FormGroup, Button } from 'react-bootstrap';
import HorizontalInputForm from '../HorizontalInputForm/HorizontalInputForm';
import classes from './LitMag.css';
import {
  priceFields,
  schoolInfoFields,
  fileFields,
} from '../../data/LitMagFormFields';

class LitMag extends Component {
  state = {
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

  handleInputChange = (event, id, stateParamName) => {
    const stateParam = { ...this.state[stateParamName] };
    stateParam[id] =
      stateParamName === 'files' ? event.target.files[0] : event.target.value;
    this.setState({
      [stateParamName]: stateParam,
    });
  };

  render() {
    return (
      <div className={classes.LitMag}>
        <h1>Literary Magazine Order Form</h1>
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
            <br />,
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
            <br />,
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
