const path = require('path')

module.exports = {
  entry: [
    './assets/js/block.js',
  ],
  module: {
    rules: [
      {
        test: /\.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
      },
    ],
  },
}