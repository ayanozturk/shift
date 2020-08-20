import React from 'react'
import ReactDom from 'react-dom'
import { DatePicker, Space, Input, Button } from "antd";

const { RangePicker } = DatePicker;
const format = 'HH:mm';

class CreateShift extends React.Component {
    render() {
        return (
            <>

                <Space direction="vertical" size={12}>
                    <Input placeholder="Shift Name" />
                    <RangePicker
                        picker="time"
                        minuteStep={15}
                        format={format}
                    />
                    <Button type="primary">Create Shift</Button>
                </Space>
            </>
        );
    }
}

ReactDom.render(<CreateShift />, document.getElementById('create-shift'))
