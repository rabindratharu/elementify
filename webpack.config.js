/**
 * Webpack configuration.
 */

// WordPress dependencies
const defaultConfig = require("@wordpress/scripts/config/webpack.config");

// External dependencies
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");

module.exports = {
  ...defaultConfig,
  entry: {
    ...defaultConfig.entry(),
    "customizer/index": "./src/customizer/index.js",
    "public/index": "./src/public/index.js",
  },
  optimization: {
    ...defaultConfig.optimization,
    minimizer: [
      ...defaultConfig.optimization.minimizer,
      new CssMinimizerPlugin(),
    ],
  },
  plugins: [...defaultConfig.plugins, new RemoveEmptyScriptsPlugin()],
};
