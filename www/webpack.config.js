var Encore = require("@symfony/webpack-encore")
const path = require("path")
const fsr = require("fs").readFileSync
const yml = require("js-yaml")
const { parameters : { configs , poll, regenDist } } = yml.safeLoad(fsr("./config/pages.yml"), yml.JSON_SCHEMA)
const EXCLUDE = ["/node_modules/", "/vendor/"]
let isSingleEntry = false;

// Config message
console.info("Don't forget to add entries in config/pages.yaml\n")
// end

// set an config object used in all workspace (front-office / admin)
const aliases = function aliases(config, alias = null) {
	let configAliases = {};
	const name = config.name,
		aliasName = alias ? alias : name.slice(0, 2);

	try {
		configAliases[`@${aliasName}`] = path.resolve(__dirname,`assets/${name}/ts`)
		configAliases[`#${aliasName}`] =  path.resolve(__dirname, `assets/${name}/scss`)
		configAliases['@core'] = path.resolve(__dirname, `assets/core/ts`)
		configAliases['#core'] = path.resolve(__dirname, `assets/core/scss`)
	} catch (e) {
		throw new Error("Pages name are probably too similar, verify your config/pages.yaml : \n" + e)
	}

	return {
		// add to all workspaces
		...config.resolve.alias, ...configAliases,
		...config.resolve.extensions.push(".scss"),
	}
}

const getWorkspaces = function getWorkspaces(entry = null) {

	let workspaces = []
	isSingleEntry = isSingleEntry || Boolean(entry)

	for (const name in configs) {

		const defaultExt = configs[name].defaultExt;
		const typescriptEnable = defaultExt === "ts"
		const pages = configs[name].pages;
		const alias = configs[name].alias;
		const buildPath = configs[name].build ? configs[name].build :`/${name}/build`;

		if (typeof entry === "string") {
			Encore.addEntry(entry, path.resolve(__dirname, `assets/${name}/${entry}`))
		} else {
			console.info(`---------\nWorkspace : ${name}\n`)

			if (!isSingleEntry) {
				Encore.cleanupOutputBeforeBuild()
			}

			pages.forEach(function(page) {
				if (typeof page === "string") {
					console.info(` - ${page}\r`)
					Encore.addEntry(`${page}`, path.resolve(__dirname, `assets/${name}/${page}`))
				} else {
					throw new Error("There is a syntax error in config/pages.yaml\n")
				}
			})
		}

		Encore

			.setOutputPath(`public/${buildPath}`)

			.setPublicPath(`/${buildPath}`)

			.disableSingleRuntimeChunk()

			.enableBuildNotifications(!Encore.isProduction())

			.enableSourceMaps(!Encore.isProduction())

			.enableVersioning(Encore.isProduction())

			.autoProvidejQuery()

			.enableSassLoader(options => {
				options.implementation = require('sass');
			})

			.enablePostCssLoader()
		;

		if (typescriptEnable) {
			Encore.enableTypeScriptLoader()

			Encore.configureBabel(config => {
				config.presets = [];
			})
		} else {
			Encore.configureBabel(config => {
				config.presets = [["@babel/preset-env", {
					"useBuiltIns": false
				}]];
			})
		}

		let config = Encore.getWebpackConfig()

		// fix build with nfs enable
		Encore.configureWatchOptions(watchOptions => {
			watchOptions.poll = poll; // check for changes every 250 milliseconds
			watchOptions.ignored = EXCLUDE;
		});

		config.name = name
		config.resolve.alias = aliases(config, alias ? alias : null)

		workspaces.push(config)

		Encore.reset()
	};

	if(!Encore.isProduction() && regenDist) {
		const fs = require("fs")
		fs.writeFile("./webpack.config.dist.json", "module.exports = "+JSON.stringify(workspaces[0]), function(err) {
			if(err) {
				throw new Error(err);
			}
			console.info('------------\nwebpack.config.dist written');
		});
	}

	return workspaces
};

module.exports = getWorkspaces();
