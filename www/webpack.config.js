var Encore = require("@symfony/webpack-encore")
const path = require("path")
const fsr = require("fs").readFileSync
const yml = require("js-yaml")
let CONFIGS = yml.safeLoad(fsr("./config/pages.yml"), yml.JSON_SCHEMA)
const EXCLUDE = "/node_modules/"
let isSingleEntry = false;

// Config message
console.info("Don't forget to add entries in config/pages.yaml\n")
// end

// set an config object used in all workspace (front-office / admin)
const aliases = function aliases(config) {
	let configAliases = {}
	let name = config.name,
		aliasName = name.slice(0, 2)

	try {
		configAliases[`@${aliasName}`] = path.resolve(__dirname,`assets/${name}/ts`)
		configAliases[`#${aliasName}`] =  path.resolve(__dirname, `assets/${name}/scss`)
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

	CONFIGS.forEach(function({ name, pages, default_ext = "js" }) {

		let typescriptEnable = default_ext === "ts"

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

			.setOutputPath(`public/build/${name}`)

			.setPublicPath(`/build/${name}`)

			.disableSingleRuntimeChunk()

			.enableBuildNotifications(!Encore.isProduction())

			.enableSourceMaps(!Encore.isProduction())

			.enableVersioning(Encore.isProduction())

			.enableSassLoader()

			.enablePostCssLoader()

		if (typescriptEnable) {
			Encore.enableTypeScriptLoader()
		}

		let config = Encore.getWebpackConfig()

		// fix build with nfs enable
		config.watchOptions = { poll: true, ignored: EXCLUDE }
		config.name = name
		config.resolve.alias = aliases(config)

		workspaces.push(config)

		Encore.reset()
	})

	return workspaces
}

module.exports = getWorkspaces();


