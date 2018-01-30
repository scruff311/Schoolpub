var webpack = require("webpack");
var path = require('path')

module.exports = {
	//the base directory (absolute path) for resolving the entry option
	context: __dirname,
	entry: "./src/index.js",
	output: {
		//where you want your compiled bundle to be stored
		path: path.resolve('./public/build/'), 
		filename: "bundle.js",
		publicPath: "build"
	},
	devServer: {
		inline: true,
		contentBase: './public',
		port: 3000
	},
	module: {
		loaders: [
      {
        test: /\.js[x]?$/,
        exclude: /(node_modules)/,
        loader: 'babel-loader',
        query: {
            'presets': [ 'es2015', 'stage-0', 'react'],
        },
      },
			{
				test: /\.json$/,
				exclude: /(node_modules)/,
				loader: "json-loader"
			},
			{
				test: /\.css$/,
				loader: 'style-loader!css-loader'
			},
			{
				test: /\.scss$/,
				loader: 'style-loader!css-loader!sass-loader'
			}
		]
	}
}







