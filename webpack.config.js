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

// Environment
const isProduction = process.env.NODE_ENV === 'production';

// Extend the default config.
const sharedConfig = {
	...scriptConfig,
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env'],
						sourceMap: !isProduction,
					},
				},
			},
			{
				test: /\.(sc|sa|c)ss$/,
				exclude: /node_modules/,
				use: [
					MiniCssExtractPlugin.loader,
					{ loader: 'css-loader', options: { sourceMap: !isProduction } },
					{ loader: 'postcss-loader', options: { sourceMap: !isProduction } },
					{ loader: 'sass-loader', options: { sourceMap: !isProduction } },
				],
			},
		],
		// Prevent Webpack from processing these files
		noParse: /\.(DS_Store)$/,
	},
	output: {
		path: path.resolve(process.cwd(), 'assets', 'build'),
		filename: 'js/[name].js', // JS files go into assets/build/js
		chunkFilename: 'js/[name].js', // Chunk files go into assets/build/js
	},
	plugins: [
		...scriptConfig.plugins.filter((plugin) => !(plugin instanceof RtlCssPlugin)),
		new MiniCssExtractPlugin({
			filename: '[name].css', // Ensure CSS files are in assets/build/css
		}),
		new RemoveEmptyScriptsPlugin({
			stage: RemoveEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
		}),
		new RtlCssPlugin({
			filename: '[name]-rtl.css', // Ensure RTL CSS files are in assets/build/css
		}),
	],
	optimization: {
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
	},
	performance: {
		maxAssetSize: 512000,
	},
	devtool: isProduction ? false : 'source-map',
	resolve: {
		modules: [
			path.resolve(process.cwd(), 'node_modules'), // Theme's node_modules
			'node_modules', // Fallback
		],
	},
};

// Generate a webpack config which includes setup for CSS extraction.
const styles = {
	...sharedConfig,
	entry: () => readAllFileEntries('./assets/src/css'),
	output: {
		...sharedConfig.output,
		path: path.resolve(process.cwd(), 'assets', 'build', 'css'), // Move CSS output to assets/build/css
	},
	module: {
		...sharedConfig.module,
	},
	plugins: [
		...sharedConfig.plugins.filter(
			(plugin) => plugin.constructor.name !== 'DependencyExtractionWebpackPlugin',
		),
	],
};

const scripts = {
	...sharedConfig,
	entry: () => readAllFileEntries('./assets/src/js'),
};

const assets = {
	...sharedConfig,
	plugins: [
		new CopyPlugin({
			patterns: [
				{
					from: './assets/src/images',
					to: 'images', // Images go into assets/build/images
				},
				// {
				// 	from: './assets/src/library',
				// 	to: 'library', // Library go into assets/build/library
				// },
			],
		}),
	],

};

module.exports = [styles, scripts, assets];
