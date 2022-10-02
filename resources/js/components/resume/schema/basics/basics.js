export default {
    fields: [
        //Picture
        {
            type: 'resume-image',
            label: 'Resume Profile Image',
            model: 'picture'
        },
        //Name
        {
            type: 'input',
            inputType: 'text',
            placeholder: 'Your name',
            label: 'Name',
            model: 'name',
            styleClasses: ['col-md-4','p-0', 'pr-md-1']
        },
        //Label
        {
            type: 'input',
            inputType: 'text',
            placeholder: 'Programmer',
            label: 'Label',
            model: 'label',
            styleClasses: ['col-md-4','p-0', 'pr-md-1']
        },
        //Email
        {
            type: 'input',
            inputType: 'text',
            placeholder: 'Your email',
            label: 'Email',
            model: 'email',
            validator: 'email',
            styleClasses: ['col-md-4','p-0', 'pr-md-1']
        },
        //Phone
        {
            type: 'input',
            inputType: 'tel',
            placeholder: '987654321',
            label: 'Phone',
            model: 'phone',
            styleClasses: ['col-md-6','p-0', 'pr-md-1']
        },
        //Website
        {
            type: 'input',
            inputType: 'text',
            placeholder: 'http://yourwebsite.com',
            label: 'Website',
            model: 'website',
            validator: 'url',
            styleClasses: ['col-md-6','p-0', 'pr-md-1']
        },
        //Summary
        {
            type: 'textArea',
            inputType: 'text',
            placeholder: 'A little bit abour yourself',
            label: 'Summary',
            model: 'summary',
        },
    ]
}