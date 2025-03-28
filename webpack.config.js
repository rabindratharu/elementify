/**
 * External dependencies
 */
const fs = require('fs');
const path = require('path');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const RtlCssPlugin = require('rtlcss-webpack-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

/**
 * WordPress dependencies
 */
const [scriptConfig] = require('@wordpress/scripts/config/webpack.config');

/**
 * Read all file entries in a directory.
 * @param {string} dir Directory to read.
 * @return {Object} Object with file entries.
 */
const readAllFileEntries = (dir) => {
  const entries = {};

  if (!fs.existsSync(dir)) {
    return entries;
  }

  if (fs.readdirSync(dir).length === 0) {
    return entries;
  }

  fs.readdirSync(dir).forEach((fileName) => {
    // Skip hidden files (starting with '.') and directories
    if (fileName.startsWith('.')) {
      return; // Skip files like .DS_Store
    }

    const fullPath = path.resolve(dir, fileName);
    if (!fs.lstatSync(fullPath).isDirectory() && !fileName.startsWith('_')) {
      entries[fileName.replace(/\.[^/.]+$/, '')] = fullPath;
    }
  });

  return entries;
};

// Shared configuration function
const getSharedConfig = (env, argv) => {
  const isProduction = argv.mode === 'production';

  const plugins = [
    ...scriptConfig.plugins.filter((plugin) => !(plugin instanceof RtlCssPlugin)),
    new CleanWebpackPlugin({
      cleanStaleWebpackAssets: isProduction
    }),
    new MiniCssExtractPlugin({
      filename: '[name].css',
    }),
    new RemoveEmptyScriptsPlugin({
      stage: RemoveEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
    }),
    new RtlCssPlugin({
      filename: '[name]-rtl.css',
    }),
  ];

  const rules = [
    {
      test: /\.js$/,
      exclude: /node_modules/,
      use: 'babel-loader'
    },
    {
      test: /\.(sc|sa|c)ss$/,
      exclude: /node_modules/,
      use: [
        MiniCssExtractPlugin.loader,
        'css-loader',
        'postcss-loader',
        'sass-loader',
      ]
    }
  ];

  const optimization = {
    ...scriptConfig.optimization,
    splitChunks: {
      ...scriptConfig.optimization.splitChunks,
    },
    minimizer: scriptConfig.optimization.minimizer.concat([
      new CssMinimizerPlugin({
        minimizerOptions: {
          preset: [
            'default',
            {
              discardComments: { removeAll: true },
              normalizeWhitespace: isProduction,
            },
          ],
        },
      }),
    ]),
  };

  return {
    ...scriptConfig,
    devtool: false,
    module: {
      rules: rules,
      noParse: /\.(DS_Store)$/,
    },
    optimization: optimization,
    plugins: plugins,
    resolve: {
      modules: [
        path.resolve(process.cwd(), 'node_modules'),
        'node_modules',
      ],
    },
    externals: {
      jquery: 'jQuery'
    }
  };
};

// Styles configuration
const stylesConfig = (env, argv) => {
  const config = getSharedConfig(env, argv);
  return {
    ...config,
    entry: () => readAllFileEntries('./assets/src/css'),
    output: {
      ...config.output,
      path: path.resolve(process.cwd(), 'assets', 'build', 'css'),
      filename: '[name].js', // Needed even though we're extracting CSS
    }
  };
};

// Scripts configuration
const scriptsConfig = (env, argv) => {
  const config = getSharedConfig(env, argv);
  return {
    ...config,
    entry: () => readAllFileEntries('./assets/src/js'),
    output: {
      ...config.output,
      path: path.resolve(process.cwd(), 'assets', 'build', 'js'),
    }
  };
};

// Assets configuration
const assetsConfig = (env, argv) => {
  const config = getSharedConfig(env, argv);
  return {
    ...config,
    plugins: [
      ...config.plugins,
      new CopyPlugin({
        patterns: [
          {
            from: './assets/src/images',
            to: path.resolve(process.cwd(), 'assets', 'build', 'images'),
          },
          {
            from: './assets/src/library',
            to: path.resolve(process.cwd(), 'assets', 'build', 'library'),
          },
        ],
      }),
    ],
    entry: {}, // No entry points needed for copy plugin
    output: {
      path: path.resolve(process.cwd(), 'assets', 'build'),
    }
  };
};

module.exports = [stylesConfig, scriptsConfig, assetsConfig];