import React, { Component } from 'react';
import { Form, FormGroup, Button } from 'react-bootstrap';
import HorizontalInputForm from '../HorizontalInputForm/HorizontalInputForm';
import classes from './LitMag.css';
import { schoolInfoFields } from '../../data/LitMagFormFields';

class LitMag extends Component {
  state = {
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
  };

  componentDidMount() {}

  handleInputChange = (event, id) => {
    const schoolInfo = { ...this.state.schoolInfo };
    schoolInfo[id] = event.target.value;
    this.setState({
      schoolInfo: schoolInfo,
    });
  };

  render() {
    return (
      <div className={classes.LitMag}>
        <h1>Literary Magazine Order Form</h1>
        <HorizontalInputForm
          title="School Information"
          changed={this.handleInputChange}
          fields={schoolInfoFields}
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
