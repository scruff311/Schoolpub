export const publicationFields = [
  {
    id: 'coverPrinting',
    label: 'Cover Printing',
    type: 'check',
    options: ['Front Cover', 'Back Cover', 'Inside Front Cover', 'Inside Back Cover'],
    width: 4,
    error: null,
    inline: false
  },
];

export const priceFields = [
  {
    id: 'promo',
    label: 'Promo Code',
    type: 'text',
    options: null,
    width: 4,
    error: null
  },
];

export const schoolInfoFields = [
  {
    id: 'name',
    label: 'School Name',
    type: 'text',
    options: null,
    width: 9,
    error: 'Please provide a school name.',
  },
  {
    id: 'advisorName',
    label: 'Advisor Name',
    type: 'text',
    options: null,
    width: 9,
    error: 'Please provide an advisor name.',
  },
  {
    id: 'address',
    label: 'School Address',
    type: 'text',
    options: null,
    width: 9,
    error: 'Please provide a street address.',
  },
  {
    id: 'city',
    label: 'City',
    type: 'text',
    options: null,
    width: 9,
    error: 'Please provide a city or town.',
  },
  {
    id: 'state',
    label: 'State',
    type: 'select',
    options: [
      'AK',
      'AL',
      'AR',
      'AZ',
      'CA',
      'CO',
      'CT',
      'DC',
      'DE',
      'FL',
      'GA',
      'HI',
      'IA',
      'ID',
      'IL',
      'IN',
      'KS',
      'KY',
      'LA',
      'MA',
      'MD',
      'ME',
      'MI',
      'MN',
      'MO',
      'MS',
      'MT',
      'NC',
      'ND',
      'NE',
      'NH',
      'NJ',
      'NM',
      'NV',
      'NY',
      'OH',
      'OK',
      'OR',
      'PA',
      'RI',
      'SC',
      'SD',
      'TN',
      'TX',
      'UT',
      'VA',
      'VT',
      'WA',
      'WI',
      'WV',
      'WY',
    ],
    width: 2,
    error: 'Please provide a state.',
  },
  {
    id: 'zip',
    label: 'Zip',
    type: 'text',
    options: null,
    width: 2,
    error: 'Please provide a zip code.',
  },
  {
    id: 'phone',
    label: 'Phone',
    type: 'text',
    options: null,
    width: 3,
    error: 'Please provide a contact phone number.',
  },
  {
    id: 'email',
    label: 'Email',
    type: 'text',
    options: null,
    width: 9,
    error: 'Please provide a contact email.',
  },
];

export const fileFields = [
  {
    id: 'file1',
    label: 'File 1',
    type: 'file',
    options: null,
    width: 3,
    error: 'A design file is required for submitting an order.'
  },
  {
    id: 'file2',
    label: 'File 2',
    type: 'file',
    options: null,
    width: 3,
    error: null
  },
  {
    id: 'file3',
    label: 'File 3',
    type: 'file',
    options: null,
    width: 3,
    error: null
  },
];
