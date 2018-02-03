import React, { Component } from 'react';
import {
  Form,
  FormGroup,
  Button,
  Col,
} from 'react-bootstrap';
import SchoolInfo from '../SchoolInfo/SchoolInfo';
import classes from './LitMag.css';

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

  componentDidMount() {
    setInterval(this.increaseCount, 1000);
  }

  increaseCount = () => {
    var count = this.state.counter;
    count++;
    this.setState({
      counter: count,
    });
  };

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
        <SchoolInfo changed={this.handleInputChange} />
        <Form horizontal>
          <FormGroup>
            <Col smOffset={2} sm={10}>
              <Button type="submit">Sign in</Button>
            </Col>
          </FormGroup>
        </Form>
        <div className={classes.DivTest} />
      </div>
    );
  }
}

export default LitMag;
