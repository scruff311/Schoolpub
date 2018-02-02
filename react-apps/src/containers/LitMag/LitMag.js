import React, { Component } from 'react';

class LitMag extends Component {
  state = {
    counter: 0,
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

  render() {
    return (
      <div className="LitMag">
        <p>Lit Mag seconds since open: {this.state.counter}</p>
        <div>
          <ul>
            <li>Salad fingers</li>
            <li>Dungy poos</li>
          </ul>
        </div>
      </div>
    );
  }
}

export default LitMag;