import React from 'react'
import ReactDom from 'react-dom'

class CreateShift extends React.Component {
    render() {
        return <h2>Shift Stuff! <span>❤️</span></h2>;
    }
}

ReactDom.render(<CreateShift />, document.getElementById('create-shift'))
