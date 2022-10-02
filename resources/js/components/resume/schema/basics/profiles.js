export default {
    fields: [
        {
            type: 'input',
            inputType: 'text',
            placeholder: 'Twitter',
            label: 'Network',
            model: 'network',
            styleClasses: ['col-md-4','p-0', 'pr-md-1']
        },
        {
            type: 'input',
            inputType: 'text',
            placeholder: 'https://twitter.com/user',
            label: 'Url',
            model: 'url',
            validator: 'url',
            styleClasses: ['col-md-4','p-0', 'pr-md-1']
        },
        {
            type: 'input',
            inputType: 'text',
            placeholder: 'yourname',
            label: 'Username',
            model: 'username',
            styleClasses: ['col-md-4','p-0', 'pr-md-1']
        }
    ]
}