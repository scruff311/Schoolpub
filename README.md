# Schoolpub

### Run the React app
1. Make sure you have a recent version of [Node.js](https://nodejs.org/en/) installed.
2. From the repo directory:

       cd react-apps
       npm install
       npm start
3. In your browser, navigate to **localhost:3000**
4. To make changes to the React apps, all the source files are located under `src/`. The logical flow is `index.html -> index.js -> LitMag.js (or Yearbook.js)`. 
    * `index.html` is where your `id` is entered which determines which React componenet is rendered in the local server.
    * `index.js` matches the `id` set in `index.html` with a React component, i.e. `LitMag.js`
5. To change the data/fields for the Literary Magazine, edit the file `data/LitMagFormFields.js`

### Build the React app
1. From the `react-apps` directory, run `npm run build`
2. This will create 5 new files under `build/`. It is these files that need to be copied over to the server so that the present html files that serve this code are updated with any changes you made.
