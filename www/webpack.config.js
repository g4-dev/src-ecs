var Encore = require("@symfony/webpack-encore")
const path = require("path")
const fsr = require("fs").readFileSync
const yml = require("js-yaml")
const CONFIGS = yml.safeLoad(fsr("./config/pages.yml"), yml.JSON_SCHEMA)
const EXCLUDE = "/node_modules/"

// set an config object used in all workspace (front-office / admin)
const aliases = (config) => {
	let configAliases = {}
	let name = config.name,
		aliasName = name.slice(0, 2)

	try {
		configAliases[`@${aliasName}`] = `assets/${name}/ts`
		configAliases[`#${aliasName}`] = `assets/${name}/scss`
	} catch (e) {
		throw new Error("Pages name are probably too similar, verify your config/pages.yaml : \n" + e)
	}

	return {
		// add to all workspaces
		...config.resolve.alias, ...configAliases,
		...config.resolve.extensions.push(".scss"),
	}
}

function getWorkspaces({ entry }) {

	let workspaces = []

	CONFIGS.forEach(function({ name, pages, default_ext }) {

		let typescriptEnable = default_ext === "ts"
		console.info(`---------\nWorkspace : ${name}\n`)

		if (entry) {
			Encore.addEntry(entry, path.resolve(__dirname, `assets/${name}/${entry}`))
		} else {

			pages.forEach(function(page) {
				if (typeof page === "string") {
					console.info(` - ${page}\r`)
					Encore.addEntry(`${page}`, path.resolve(__dirname, `assets/${name}/${page}`))

				} else if (typeof page === "object") {
					let { entry, ext } = page
					console.info(`entry : ${entry}\r`)
					Encore.addEntry(`${entry}`, path.resolve(__dirname, `assets/${name}/${entry}`))
					typescriptEnable = typescriptEnable || ext === "ts"

				} else {
					throw new Error("There is a syntax error in config/pages.yaml\n")
				}
			})

		}

		Encore

			.cleanupOutputBeforeBuild()

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

module.exports = function(env) {
	return getWorkspaces(env)
}

