import React, {useState} from 'react';
import ReactDom from 'react-dom'
import {Button, DatePicker, Input, Space} from "antd";
import moment from 'moment';

const { RangePicker } = DatePicker;
const format = 'HH:mm';

function CreateShift() {
    const defaultStart = moment('09:00', 'HH:mm')
    const defaultEnd = defaultStart.clone().add(8, 'hours')
    const [shiftRange, setShiftRange] = useState([defaultStart, defaultEnd])
    return (
        <>
            <Space direction="vertical" size={12}>
                <Input placeholder="Shift Name"/>
                <RangePicker
                    value={shiftRange}
                    picker="time"
                    minuteStep={15}
                    format={format}
                    onCalendarChange={value => {
                        setShiftRange(value)
                    }}
                />
                <Button type="primary">Create Shift</Button>
            </Space>
        </>
    );
}

ReactDom.render(<CreateShift />, document.getElementById('create-shift'))
