module.exports = {
    "context": "/data/ecs/www",
    "entry": {
        "homepage": "/data/ecs/www/assets/front_office/homepage",
        "accounting": "/data/ecs/www/assets/front_office/accounting",
        "shopping": "/data/ecs/www/assets/front_office/shopping",
        "proServiceList": "/data/ecs/www/assets/front_office/proServiceList",
        "cmsShow": "/data/ecs/www/assets/front_office/cmsShow",
        "cmsList": "/data/ecs/www/assets/front_office/cmsList",
        "diyShow": "/data/ecs/www/assets/front_office/diyShow",
        "diyList": "/data/ecs/www/assets/front_office/diyList",
        "productList": "/data/ecs/www/assets/front_office/productList",
        "productShow": "/data/ecs/www/assets/front_office/productShow"
    },
    "mode": "development",
    "output": {
        "path": "/data/ecs/www/public/front_office/build",
        "filename": "[name].js",
        "publicPath": "/front_office/build/",
        "pathinfo": true
    },
    "module": {
        "rules": [{
            "test": {},
            "exclude": {},
            "use": [{
                "loader": "babel-loader",
                "options": {
                    "cacheDirectory": true,
                    "sourceType": "unambiguous",
                    "presets": [],
                    "plugins": ["@babel/plugin-syntax-dynamic-import"]
                }
            }]
        }, {
            "resolve": {
                "mainFields": ["style", "main"],
                "extensions": [".css", ".postcss"]
            },
            "test": {},
            "oneOf": [{
                "resourceQuery": {},
                "use": ["/data/ecs/www/node_modules/mini-css-extract-plugin/dist/loader.js", {
                    "loader": "css-loader",
                    "options": {
                        "sourceMap": true,
                        "importLoaders": 1,
                        "modules": true,
                        "localIdentName": "[local]_[hash:base64:5]"
                    }
                }, {"loader": "postcss-loader", "options": {"sourceMap": true}}]
            }, {
                "use": ["/data/ecs/www/node_modules/mini-css-extract-plugin/dist/loader.js", {
                    "loader": "css-loader",
                    "options": {
                        "sourceMap": true,
                        "importLoaders": 1,
                        "modules": false,
                        "localIdentName": "[local]_[hash:base64:5]"
                    }
                }, {"loader": "postcss-loader", "options": {"sourceMap": true}}]
            }]
        }, {
            "test": {},
            "loader": "file-loader",
            "options": {
                "name": "images/[name].[hash:8].[ext]",
                "publicPath": "/front_office/build/"
            }
        }, {
            "test": {},
            "loader": "file-loader",
            "options": {
                "name": "fonts/[name].[hash:8].[ext]",
                "publicPath": "/front_office/build/"
            }
        }, {
            "resolve": {
                "mainFields": ["sass", "style", "main"],
                "extensions": [".scss", ".sass", ".css"]
            },
            "test": {},
            "oneOf": [{
                "resourceQuery": {},
                "use": ["/data/ecs/www/node_modules/mini-css-extract-plugin/dist/loader.js", {
                    "loader": "css-loader",
                    "options": {
                        "sourceMap": true,
                        "importLoaders": 1,
                        "modules": true,
                        "localIdentName": "[local]_[hash:base64:5]"
                    }
                }, {
                    "loader": "postcss-loader",
                    "options": {"sourceMap": true}
                }, {
                    "loader": "resolve-url-loader",
                    "options": {"sourceMap": true}
                }, {
                    "loader": "sass-loader",
                    "options": {
                        "sourceMap": true,
                        "outputStyle": "expanded",
                        "implementation": {
                            "info": "dart-sass\t1.26.2\t(Sass Compiler)\t[Dart]\ndart2js\t2.7.1\t(Dart Compiler)\t[Dart]",
                            "types": {}
                        }
                    }
                }]
            }, {
                "use": ["/data/ecs/www/node_modules/mini-css-extract-plugin/dist/loader.js", {
                    "loader": "css-loader",
                    "options": {
                        "sourceMap": true,
                        "importLoaders": 1,
                        "modules": false,
                        "localIdentName": "[local]_[hash:base64:5]"
                    }
                }, {
                    "loader": "postcss-loader",
                    "options": {"sourceMap": true}
                }, {
                    "loader": "resolve-url-loader",
                    "options": {"sourceMap": true}
                }, {
                    "loader": "sass-loader",
                    "options": {
                        "sourceMap": true,
                        "outputStyle": "expanded",
                        "implementation": {
                            "info": "dart-sass\t1.26.2\t(Sass Compiler)\t[Dart]\ndart2js\t2.7.1\t(Dart Compiler)\t[Dart]",
                            "types": {}
                        }
                    }
                }]
            }]
        }, {
            "test": {},
            "exclude": {},
            "use": [{
                "loader": "babel-loader",
                "options": {
                    "cacheDirectory": true,
                    "sourceType": "unambiguous",
                    "presets": [],
                    "plugins": ["@babel/plugin-syntax-dynamic-import"]
                }
            }, {"loader": "ts-loader", "options": {"silent": true}}]
        }]
    },
    "plugins": [{
        "options": {
            "filename": "[name].css",
            "chunkFilename": "[name].css"
        }
    }, {"entriesToDelete": []}, {
        "opts": {
            "publicPath": null,
            "basePath": "front_office/build/",
            "fileName": "manifest.json",
            "transformExtensions": {},
            "writeToFileEmit": true,
            "seed": {},
            "map": null,
            "generate": null,
            "sort": null
        }
    }, {
        "paths": ["**/*"],
        "options": {
            "root": "/data/ecs/www/public/front_office/build",
            "verbose": false,
            "allowExternal": false,
            "dry": false
        }
    }, {"definitions": {"process.env": {"NODE_ENV": "\"development\""}}}, {
        "options": {"title": "Webpack Encore"},
        "lastBuildSucceeded": false,
        "isFirstBuild": true
    }, {
        "compilationSuccessInfo": {"messages": []},
        "shouldClearConsole": false,
        "formatters": [null, null, null, null, null, null],
        "transformers": [null, null, null, null, null, null],
        "previousEndTimes": {}
    }, {
        "outputPath": "public/front_office/build",
        "friendlyErrorsPlugin": {
            "compilationSuccessInfo": {"messages": []},
            "shouldClearConsole": false,
            "formatters": [null, null, null, null, null, null],
            "transformers": [null, null, null, null, null, null],
            "previousEndTimes": {}
        }
    }, {
        "options": {
            "filename": "entrypoints.json",
            "prettyPrint": false,
            "update": false,
            "fullPath": true,
            "manifestFirst": true,
            "useCompilerPath": false,
            "fileTypes": ["js", "css"],
            "includeAllFileTypes": true,
            "keepInMemory": false,
            "integrity": false,
            "path": "/data/ecs/www/public/front_office/build",
            "entrypoints": true
        }
    }],
    "optimization": {
        "namedModules": true,
        "chunkIds": "named",
        "splitChunks": {"chunks": "async"}
    },
    "watchOptions": {"ignored": {}},
    "devtool": "inline-source-map",
    "performance": {"hints": false},
    "stats": {
        "hash": false,
        "version": false,
        "timings": false,
        "assets": false,
        "chunks": false,
        "maxModules": 0,
        "modules": false,
        "reasons": false,
        "children": false,
        "source": false,
        "errors": false,
        "errorDetails": false,
        "warnings": false,
        "publicPath": false,
        "builtAt": false
    },
    "resolve": {
        "extensions": [".wasm", ".mjs", ".js", ".json", ".jsx", ".vue", ".ts", ".tsx", ".scss"],
        "alias": {
            "@fo": "/data/ecs/www/assets/front_office/ts",
            "#fo": "/data/ecs/www/assets/front_office/scss",
            "@core": "/data/ecs/www/assets/core/ts",
            "#core": "/data/ecs/www/assets/core/scss",
            "@admin": "/data/ecs/www/assets/admin/ts",
            "#admin": "/data/ecs/www/assets/admin/scss"
        }
    },
    "externals": [],
    "name": "front_office"
}